from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from time import sleep
from colorama import init
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
    
    verify_user_link = submenu.find_element(By.XPATH, ".//a[normalize-space()='Verify User']")
    verify_user_link.click()

    sleep(0.5)

    last_page = WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.XPATH, "//ul[@class='pagination']/li[last()-1]/a"))
    )
    last_page.click()

    sleep(2)
    
    driver.execute_script("window.scrollTo(0, document.body.scrollHeight);")
    WebDriverWait(driver, 5).until(lambda d: d.execute_script("return (window.innerHeight + window.scrollY) >= document.body.scrollHeight"))
    
    first_row = WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.XPATH, "//table/tbody/tr[1]"))
    )
    view_button = first_row.find_element(By.XPATH, ".//button[@title='View']")
    view_button.click()

    modal_footer = WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.CLASS_NAME, "modal-footer"))
    )

    verify_button = modal_footer.find_element(By.CSS_SELECTOR, "button.btn-success a.text-white")
    driver.execute_script("arguments[0].scrollIntoView(true);", verify_button)
    driver.implicitly_wait(1)
    driver.execute_script("arguments[0].click();", verify_button)
    driver.quit()

if __name__ == "__main__":
    run_selenium_test()