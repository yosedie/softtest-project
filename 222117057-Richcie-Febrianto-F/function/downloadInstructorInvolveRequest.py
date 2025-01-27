from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from time import sleep
from colorama import Fore, init
import os

init()

def run_selenium_test():
    service = Service('./chromedriver.exe')

    current_dir = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
    download_dir = os.path.join(current_dir, 'downloads')
    os.makedirs(download_dir, exist_ok=True)

    chrome_options = webdriver.ChromeOptions()
    prefs = {
        "download.default_directory": download_dir,  
        "download.prompt_for_download": False,       
        "download.directory_upgrade": True,          
        "safebrowsing.enabled": True                 
    }
    chrome_options.add_experimental_option("prefs", prefs)

    driver = webdriver.Chrome(service=service, options=chrome_options)
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

    pdf_button = WebDriverWait(driver, 10).until(
        EC.element_to_be_clickable((By.XPATH, "//a[contains(@class, 'buttons-pdf')]/span[text()='PDF']"))
    )
    actions.move_to_element(pdf_button).click().perform()
    sleep(2)
    
    print(Fore.GREEN + "File tersimpan di : ./downloads" + Fore.RESET)

    driver.quit()

if __name__ == "__main__":
    run_selenium_test()