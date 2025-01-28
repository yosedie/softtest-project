from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import Select
from selenium.webdriver.common.keys import Keys
from time import sleep
from colorama import Fore, init
import os
import random
import string
import logging
from datetime import datetime

init()

def setup_logging():
    # Create logs directory if it doesn't exist
    if not os.path.exists('logs'):
        os.makedirs('logs')
    
    # Create timestamp for log filename
    timestamp = datetime.now().strftime('%Y%m%d_%H%M%S')
    log_filename = os.path.join('logs', f'addUser_{timestamp}.log')
    
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
    logger.info(f"Starting Add User test - Log file: {log_filename}")
    
    try:
        logger.info("Starting Add User test")
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

        add_user_button = WebDriverWait(driver, 10).until(
            EC.element_to_be_clickable((By.XPATH, "//a[@class='btn btn-primary-rgba mr-2' and @title='Add User']"))
        )
        add_user_button.click()
        logger.info("Clicked Add User button")

        project_root = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
        names_file = os.path.join(project_root, 'data', 'names.txt')
        emails_file = os.path.join(project_root, 'data', 'emails.txt')
        phoneNumber_file = os.path.join(project_root, 'data', 'phoneNumber.txt')
        addresses_file = os.path.join(project_root, 'data', 'addresses.txt')
        logger.info("Loaded data files")

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
        password = generate_password()
        logger.info(f"Generated random user data: {first_name} {last_name}, {email}")

        WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.NAME, "fname"))).send_keys(first_name)
        driver.find_element(By.NAME, "lname").send_keys(last_name)
        driver.find_element(By.NAME, "email").send_keys(email)
        driver.find_element(By.NAME, "mobile").send_keys(phone)
        driver.find_element(By.NAME, "password").send_keys(password)
        logger.info("Filled basic user information")

        roles = ["admin", "user", "instructor", "manager"]
        random_role = random.choice(roles)
        role_select = driver.find_element(By.NAME, "role")
        role_select.find_element(By.XPATH, f"//option[@value='{random_role}']").click()
        logger.info(f"Selected role: {random_role}")

        with open(addresses_file, 'r') as f:
            addresses = f.readlines()

        address = random.choice(addresses).strip()
        address_parts = address.rsplit(' ', 1)
        street_address = address_parts[0]
        pincode = address_parts[1]
        logger.info(f"Generated address: {street_address}, {pincode}")

        wait = WebDriverWait(driver, 10)
        address_field = wait.until(EC.presence_of_element_located((By.NAME, "address")))
        address_field.send_keys(street_address)
        logger.info("Entered address")

        dropdown = WebDriverWait(driver, 10).until(
            EC.element_to_be_clickable((By.ID, "select2-country_id-container"))
        )
        dropdown.click()

        search_input = WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.CSS_SELECTOR, ".select2-search__field"))
        )
        search_input.send_keys("India")
        search_input.send_keys(Keys.ENTER)
        logger.info("Selected country: India")

        sleep(1)

        state_dropdown = WebDriverWait(driver, 10).until(
            EC.element_to_be_clickable((By.ID, "select2-state_id-container"))
        )
        state_dropdown.click()

        state_search_input = WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.CSS_SELECTOR, ".select2-search__field"))
        )
        state_search_input.send_keys("Kerala")
        state_search_input.send_keys(Keys.ENTER)
        logger.info("Selected state: Kerala")

        pincode_field = wait.until(EC.presence_of_element_located((By.NAME, "pin_code")))
        pincode_field.send_keys(pincode)
        logger.info("Entered pincode")

        current_dir = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
        file_path = os.path.join(current_dir, 'data', 'dummy-picture.jpg')
        file_input = WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.ID, "user_img_one"))
        )
        file_input.send_keys(file_path)
        logger.info("Uploaded profile picture")

        create_button = WebDriverWait(driver, 10).until(
            EC.element_to_be_clickable((By.XPATH, "//button[@type='submit' and @class='btn btn-primary-rgba' and @title=' Create']"))
        )
        create_button.click()
        logger.info("Clicked create button")

        success_info = (
            f"Created new user:\n"
            f"Fullname: {first_name} {last_name}\n"
            f"Email: {email}\n"
            f"Role: {random_role}"
        )
        logger.info(success_info)

        print(Fore.GREEN + "Membuat user dengan informasi :" + Fore.RESET)
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