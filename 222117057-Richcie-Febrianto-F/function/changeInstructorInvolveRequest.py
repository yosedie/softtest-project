from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from time import sleep
from colorama import Fore, init
import random

init()

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
        EC.presence_of_element_located((By.XPATH, "//a[contains(@class, 'menu')]/span[contains(text(), 'Instructors')]"))
    )
    actions.move_to_element(users_menu).click().perform()
    
    submenu = WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.CSS_SELECTOR, "ul.vertical-submenu.menu-open"))
    )
    
    multiple_instructor_dropdown = submenu.find_element(By.XPATH, ".//a[normalize-space()='Multiple Instructor']")
    multiple_instructor_dropdown.click()

    request_involve_link = submenu.find_element(By.XPATH, ".//a[normalize-space()='Request to Involve']")
    request_involve_link.click()

    sleep(5)
    
    row = WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.CSS_SELECTOR, "tbody tr[role='row']:first-child"))
    )

    featured_switch = row.find_element(By.CSS_SELECTOR, "td:nth-child(5) input.featured")
    driver.execute_script("arguments[0].click();", featured_switch)
    
    status_switch = row.find_element(By.CSS_SELECTOR, "td:nth-child(6) input.status")
    driver.execute_script("arguments[0].click();", status_switch)

    modal_button = row.find_element(By.CSS_SELECTOR, "td:last-child a[data-target='#involverequest5']")
    driver.execute_script("arguments[0].click();", modal_button)

    sleep(.75)

    select2_dropdown = WebDriverWait(driver, 10).until(
        EC.element_to_be_clickable((By.CSS_SELECTOR, "span.select2-selection--single"))
    )
    select2_dropdown.click()

    options = WebDriverWait(driver, 10).until(
        EC.presence_of_all_elements_located((By.CSS_SELECTOR, "li.select2-results__option"))
    )

    random_option = random.choice(options)
    selected_text = random_option.text
    random_option.click()
    
    reason_textarea = driver.find_element(By.NAME, "reason")
    reason_textarea.send_keys("Automated reason for involvement request.")  
    
    submit_button = WebDriverWait(driver, 10).until(
        EC.element_to_be_clickable((By.CSS_SELECTOR, ".modal-body form button[type='submit'][title='Update']"))
    )
    driver.execute_script("arguments[0].click();", submit_button)

    print(Fore.GREEN + "Mengedit permintaan involvement instruktor :" + Fore.RESET)
    print(Fore.GREEN + f"Nama instructor : {selected_text}" + Fore.RESET)
    print(Fore.GREEN + f"Alasan : Automated reason for involvement request." + Fore.RESET)
    print(Fore.GREEN + f"Toggle (Featured / Status) : On -> Off / Off -> On" + Fore.RESET)

    driver.quit()

if __name__ == "__main__":
    run_selenium_test()