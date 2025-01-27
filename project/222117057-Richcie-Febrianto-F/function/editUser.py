from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.keys import Keys
from time import sleep
from colorama import Fore, init
import os
import random
import string

init()

def generate_password(length=12):
    characters = string.ascii_letters + string.digits + string.punctuation
    return ''.join(random.choice(characters) for _ in range(length))

def run_selenium_test():
    service = Service('./chromedriver.exe')
    driver = webdriver.Chrome(service=service)

    driver.maximize_window()
    driver.get('https://eclass.mediacity.co.in/demo2/public')

    login_button = driver.find_element(By.XPATH, "//a[text()='Login']")
    actions = ActionChains(driver)
    actions.move_to_element(login_button).perform()
    login_button.click()

    email_field = WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.NAME, "email"))
    )
    email_field.send_keys("admin@mediacity.co.in")

    password_field = driver.find_element(By.NAME, "password")
    password_field.send_keys("123456")

    decline_button = WebDriverWait(driver, 10).until(
        EC.element_to_be_clickable((By.ID, "cookie-decline"))
    )
    decline_button.click()

    login_button = WebDriverWait(driver, 10).until(
        EC.element_to_be_clickable((By.XPATH, "//button[@type='submit' and contains(text(), 'Login')]"))
    )
    login_button.click()
    
    actions = ActionChains(driver)
    
    users_menu = WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.XPATH, "//a[contains(@class, 'menu')]/span[contains(text(), 'Users')]"))
    )
    actions.move_to_element(users_menu).click().perform()
    
    submenu = WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.CSS_SELECTOR, "ul.vertical-submenu.menu-open"))
    )
    
    all_users_link = submenu.find_element(By.XPATH, ".//a[normalize-space()='All Users']")
    all_users_link.click()

    sleep(0.5)

    last_page = WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.XPATH, "//ul[@class='pagination']/li[last()-1]/a"))
    )
    last_page.click()

    sleep(2)

    driver.execute_script("window.scrollTo(0, document.body.scrollHeight);")
    WebDriverWait(driver, 5).until(lambda d: d.execute_script("return (window.innerHeight + window.scrollY) >= document.body.scrollHeight"))

    settings_button = WebDriverWait(driver, 10).until(
        EC.element_to_be_clickable((By.XPATH,
            "//tr[@role='row' and contains(@class, 'odd')]//button[@title='Settings']"
        ))
    )
    action = ActionChains(driver)
    action.move_to_element(settings_button).click().perform()

    
    edit_option = WebDriverWait(driver, 10).until(
        EC.element_to_be_clickable((By.XPATH, "//a[@class='dropdown-item' and @title='Edit']"))
    )
    edit_option.click()

    sleep(3)

    project_root = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
    names_file = os.path.join(project_root, 'data', 'names.txt')
    emails_file = os.path.join(project_root, 'data', 'emails.txt')
    phoneNumber_file = os.path.join(project_root, 'data', 'phoneNumber.txt')
    addresses_file = os.path.join(project_root, 'data', 'addresses.txt')

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
    
    fname_field = WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.NAME, "fname"))
    )
    fname_field.clear()
    fname_field.send_keys(first_name)
    driver.find_element(By.NAME, "lname").clear()
    driver.find_element(By.NAME, "lname").send_keys(last_name)
    driver.find_element(By.NAME, "email").clear()
    driver.find_element(By.NAME, "email").send_keys(email)
    driver.find_element(By.NAME, "mobile").clear()
    driver.find_element(By.NAME, "mobile").send_keys(phone)

    roles = ["admin", "user", "instructor", "manager"]
    random_role = random.choice(roles)
    role_select = driver.find_element(By.NAME, "role")
    role_select.find_element(By.XPATH, f"//option[@value='{random_role}']").click()

    with open(addresses_file, 'r') as f:
        addresses = f.readlines()

    address = random.choice(addresses).strip()
    address_parts = address.rsplit(' ', 1)
    street_address = address_parts[0]
    pincode = address_parts[1]

    wait = WebDriverWait(driver, 10)

    address_field = wait.until(EC.presence_of_element_located((By.NAME, "address")))
    address_field.clear()
    address_field.send_keys(street_address)

    dropdown = WebDriverWait(driver, 10).until(
        EC.element_to_be_clickable((By.ID, "select2-country_id-container"))
    )
    dropdown.click()

    search_input = WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.CSS_SELECTOR, ".select2-search__field"))
    )
    search_input.send_keys("India")
    search_input.send_keys(Keys.ENTER)

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

    pincode_field = wait.until(EC.presence_of_element_located((By.NAME, "pin_code")))
    pincode_field.clear()
    pincode_field.send_keys(pincode)

    current_dir = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
    file_path = os.path.join(current_dir, 'data', 'dummy-picture.jpg')
    file_input = WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.ID, "user_img_one"))
    )
    file_input.send_keys(file_path)

    update_button = WebDriverWait(driver, 10).until(
        EC.element_to_be_clickable((By.XPATH, "//button[@type='submit' and @title='Update']"))
    )
    update_button.click()

    print(Fore.GREEN + "Mengedit user dengan informasi :" + Fore.RESET)
    print(Fore.GREEN + f"Fullname : {first_name} {last_name}" + Fore.RESET)
    print(Fore.GREEN + f"Email : {email}" + Fore.RESET)
    print(Fore.GREEN + f"Role : {random_role}" + Fore.RESET)

    driver.quit()

if __name__ == "__main__":
    run_selenium_test()