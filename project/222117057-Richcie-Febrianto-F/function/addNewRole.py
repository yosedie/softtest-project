from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
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

    verify_user_link = submenu.find_element(By.XPATH, ".//a[normalize-space()='Roles And Permission']")
    verify_user_link.click()

    sleep(0.5)

    button = WebDriverWait(driver, 10).until(
        EC.element_to_be_clickable((By.CSS_SELECTOR, "a[href='https://eclass.mediacity.co.in/demo2/public/roles/create']"))
    )
    actions.move_to_element(button).click().perform()

    project_root = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
    names_file = os.path.join(project_root, 'data', 'names.txt')

    with open(names_file, 'r', encoding='utf-8') as f:
        lines = [line.strip() for line in f if line.strip()]  
    random_name = random.choice(lines)

    name_input = driver.find_element(By.ID, 'name')
    name_input.clear()
    name_input.send_keys(random_name)

    select_all_checkbox = driver.find_element(By.CSS_SELECTOR, 'input.grand_selectall[type="checkbox"]')
    select_all_checkbox.click()

    driver.execute_script("window.scrollTo(0, document.body.scrollHeight);")

    sleep(2)

    create_button = WebDriverWait(driver, 10).until(
        EC.element_to_be_clickable(
            (By.XPATH, "//button[@type='submit' and contains(., 'Create')]")
        )
    )
    
    create_button.click()

    print(Fore.GREEN + f"Sukses membuat role baru dengan nama : {random_name}" + Fore.RESET)

    driver.quit()

if __name__ == "__main__":
    run_selenium_test()