from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from time import sleep
from colorama import init
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
    
    settings_button = WebDriverWait(driver, 10).until(
        EC.element_to_be_clickable((By.XPATH,
            "//tr[@role='row' and contains(@class, 'odd')]//button[@title='Settings']"
        ))
    )
    action = ActionChains(driver)
    action.move_to_element(settings_button).click().perform()

    view_option = WebDriverWait(driver, 10).until(
        EC.element_to_be_clickable((By.XPATH, "//button[@class='dropdown-item' and @title='View']"))
    )
    action = ActionChains(driver)
    action.move_to_element(view_option).click().perform()

    driver.quit()

if __name__ == "__main__":
    run_selenium_test()