from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.keys import Keys
from time import sleep
from colorama import Fore, init
import random
import string
import logging
import os
from datetime import datetime

init()

def setup_logging():
    # Create logs directory if it doesn't exist
    if not os.path.exists('logs'):
        os.makedirs('logs')
    
    # Create timestamp for log filename
    timestamp = datetime.now().strftime('%Y%m%d_%H%M%S')
    log_filename = os.path.join('logs', f'editUser_{timestamp}.log')
    
    # Configure logging
    logging.basicConfig(
        level=logging.INFO,
        format='%(asctime)s - %(levelname)s - %(message)s',
        handlers=[
            logging.FileHandler(log_filename, encoding='utf-8'),
            logging.StreamHandler()
        ]
    )
    return log_filename

def generate_password(length=12):
    characters = string.ascii_letters + string.digits + string.punctuation
    return ''.join(random.choice(characters) for _ in range(length))

def run_selenium_test():
    log_filename = setup_logging()
    logger = logging.getLogger(__name__)
    logger.info(f"Starting Edit User test - Log file: {log_filename}")
    try:
        logger.info("Starting Edit User test")
        service = Service('./chromedriver.exe')
        driver = webdriver.Chrome(service=service)
        logger.info("Chrome driver initialized")

        driver.maximize_window()
        driver.get('https://eclass.mediacity.co.in/demo2/public')
        logger.info("Navigated to website")

        login_button = driver.find_element(By.XPATH, "//a[text()='Login']")
        actions = ActionChains(driver)
        actions.move_to_element(login_button).perform()
        login_button.click()
        logger.info("Clicked login button")

        email_field = WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.NAME, "email"))
        )
        email_field.send_keys("admin@mediacity.co.in")
        logger.info("Entered email")

        password_field = driver.find_element(By.NAME, "password")
        password_field.send_keys("123456")
        logger.info("Entered password")

        decline_button = WebDriverWait(driver, 10).until(
            EC.element_to_be_clickable((By.ID, "cookie-decline"))
        )
        decline_button.click()
        logger.info("Declined cookies")

        login_button = WebDriverWait(driver, 10).until(
            EC.element_to_be_clickable((By.XPATH, "//button[@type='submit' and contains(text(), 'Login')]"))
        )
        login_button.click()
        logger.info("Submitted login form")
        
        actions = ActionChains(driver)
        
        users_menu = WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.XPATH, "//a[contains(@class, 'menu')]/span[contains(text(), 'Users')]"))
        )
        actions.move_to_element(users_menu).click().perform()
        logger.info("Clicked Users menu")
        
        submenu = WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.CSS_SELECTOR, "ul.vertical-submenu.menu-open"))
        )
        logger.info("Submenu opened")
        
        all_users_link = submenu.find_element(By.XPATH, ".//a[normalize-space()='All Users']")
        all_users_link.click()
        logger.info("Navigated to All Users page")

        sleep(0.5)

        last_page = WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.XPATH, "//ul[@class='pagination']/li[last()-1]/a"))
        )
        last_page.click()
        logger.info("Clicked last page")

        sleep(2)

        driver.execute_script("window.scrollTo(0, document.body.scrollHeight);")
        WebDriverWait(driver, 5).until(lambda d: d.execute_script("return (window.innerHeight + window.scrollY) >= document.body.scrollHeight"))
        logger.info("Scrolled to the bottom of the page")

        WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.ID, "test"))
        )
        logger.info("Table found")

        sleep(2)

        try:
            settings_button = WebDriverWait(driver, 10).until(
                EC.element_to_be_clickable((By.CSS_SELECTOR, "tbody tr:last-child td:last-child button[title='Settings']"))
            )
            driver.execute_script("arguments[0].click();", settings_button)
            logger.info("Clicked settings button using title selector")
        except:
            buttons = WebDriverWait(driver, 10).until(
                EC.presence_of_all_elements_located((By.CSS_SELECTOR, "button.btn-outline-primary"))
            )
            if buttons:
                driver.execute_script("arguments[0].click();", buttons[-1])
                logger.info("Clicked settings button using fallback method")
        
        # First wait for dropdown to be visible
        WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.CLASS_NAME, "dropdown-menu"))
        )
        logger.info("Dropdown menu appeared")

        edit_link = WebDriverWait(driver, 10).until(
            EC.element_to_be_clickable((By.CSS_SELECTOR, "tr:last-child .dropdown-menu.show a[title='Edit']"))
        )
        driver.execute_script("arguments[0].click();", edit_link)
        logger.info("Navigated to edit user page")

        sleep(3)

        project_root = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
        names_file = os.path.join(project_root, 'data', 'names.txt')
        emails_file = os.path.join(project_root, 'data', 'emails.txt')
        phoneNumber_file = os.path.join(project_root, 'data', 'phoneNumber.txt')
        addresses_file = os.path.join(project_root, 'data', 'addresses.txt')
        logger.info("Loaded all .txt files from ./data")

        with open(names_file, 'r') as f:
            names = f.read().splitlines()

        with open(emails_file, 'r') as f:
            emails = f.read().splitlines()

        with open(phoneNumber_file, 'r') as f:
            phone_numbers = f.read().splitlines()

        first_name = random.choice(names)
        last_name = random.choice(names)
        email = random.choice(emails)
        phone = random.choice(phone_numbers)
        logger.info("Randomed all form from .txt files ./data")
        
        fname_field = WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.NAME, "fname"))
        )
        logger.info("Form loaded")

        fname_field.clear()
        fname_field.send_keys(first_name)
        logger.info("Edited firstname")

        driver.find_element(By.NAME, "lname").clear()
        driver.find_element(By.NAME, "lname").send_keys(last_name)
        logger.info("Edited lastname")

        driver.find_element(By.NAME, "email").clear()
        driver.find_element(By.NAME, "email").send_keys(email)
        logger.info("Edited email")

        driver.find_element(By.NAME, "mobile").clear()
        driver.find_element(By.NAME, "mobile").send_keys(phone)
        logger.info("Edited phone")

        roles = ["admin", "user", "instructor", "manager"]
        random_role = random.choice(roles)
        logger.info("Randomed roles for form")

        role_select = driver.find_element(By.NAME, "role")
        role_select.find_element(By.XPATH, f"//option[@value='{random_role}']").click()
        logger.info("Clicked roles from dropdown role select")

        with open(addresses_file, 'r') as f:
            addresses = f.readlines()

        address = random.choice(addresses).strip()
        logger.info("Randomed address from .txt files ./data")

        address_parts = address.rsplit(' ', 1)
        street_address = address_parts[0]
        pincode = address_parts[1]

        wait = WebDriverWait(driver, 10)
        logger.info("Initialized WebDriverWait")

        address_field = wait.until(EC.presence_of_element_located((By.NAME, "address")))
        logger.info("Address loaded")

        address_field.clear()
        address_field.send_keys(street_address)
        logger.info("Edited address form")

        dropdown = WebDriverWait(driver, 10).until(
            EC.element_to_be_clickable((By.ID, "select2-country_id-container"))
        )
        dropdown.click()
        logger.info("Clicked country dropdown")

        search_input = WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.CSS_SELECTOR, ".select2-search__field"))
        )
        search_input.send_keys("India")
        search_input.send_keys(Keys.ENTER)
        logger.info("Edited country search")

        sleep(1)

        state_dropdown = WebDriverWait(driver, 10).until(
            EC.element_to_be_clickable((By.ID, "select2-state_id-container"))
        )
        state_dropdown.click()
        logger.info("Clicked state dropdown")

        state_search_input = WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.CSS_SELECTOR, ".select2-search__field"))
        )
        state_search_input.send_keys("Kerala")
        state_search_input.send_keys(Keys.ENTER)
        logger.info("Edited state search")

        pincode_field = wait.until(EC.presence_of_element_located((By.NAME, "pin_code")))
        pincode_field.clear()
        pincode_field.send_keys(pincode)
        logger.info("Edited pincode address form")

        current_dir = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
        file_path = os.path.join(current_dir, 'data', 'dummy-picture.jpg')
        logger.info("Loaded dummy-picture.jpg from ./data")

        file_input = WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.ID, "user_img_one"))
        )
        file_input.send_keys(file_path)
        logger.info("Edited file input to dummy-picture.jpg")

        update_button = WebDriverWait(driver, 10).until(
            EC.element_to_be_clickable((By.XPATH, "//button[@type='submit' and @title='Update']"))
        )
        update_button.click()
        logger.info("Clicked update button")

        success_info = (
            f"Edited user information:\n"
            f"Fullname: {first_name} {last_name}\n"
            f"Email: {email}\n"
            f"Role: {random_role}"
        )
        logger.info(success_info)

        print(Fore.GREEN + "Mengedit user dengan informasi :" + Fore.RESET)
        print(Fore.GREEN + f"Fullname : {first_name} {last_name}" + Fore.RESET)
        print(Fore.GREEN + f"Email : {email}" + Fore.RESET)
        print(Fore.GREEN + f"Role : {random_role}" + Fore.RESET)

        driver.quit()
        logger.info("Browser closed successfully")
    except Exception as e:
        logger.error(f"Error occurred: {str(e)}")
        if 'driver' in locals():
            driver.quit()
            logger.info("Browser closed after error")
        raise

if __name__ == "__main__":
    run_selenium_test()