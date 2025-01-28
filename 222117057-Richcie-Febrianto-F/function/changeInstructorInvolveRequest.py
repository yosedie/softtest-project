from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from time import sleep
from colorama import Fore, init
import random
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
    log_filename = os.path.join('logs', f'changeInstructorInvolveRequest_{timestamp}.log')
    
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

def run_selenium_test():
    log_filename = setup_logging()
    logger = logging.getLogger(__name__)
    logger.info(f"Starting Block User test - Log file: {log_filename}")
    try:
        logger.info("Starting Block User test")
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
            EC.presence_of_element_located((By.XPATH, "//a[contains(@class, 'menu')]/span[contains(text(), 'Instructors')]"))
        )
        actions.move_to_element(users_menu).click().perform()
        logger.info("Clicked Instructors menu")
        
        submenu = WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.CSS_SELECTOR, "ul.vertical-submenu.menu-open"))
        )
        logger.info("Submenu opened")
        
        multiple_instructor_dropdown = submenu.find_element(By.XPATH, ".//a[normalize-space()='Multiple Instructor']")
        multiple_instructor_dropdown.click()
        logger.info("Clicked Multiple Instructor dropdown")

        request_involve_link = submenu.find_element(By.XPATH, ".//a[normalize-space()='Request to Involve']")
        request_involve_link.click()
        logger.info("Navigated to Request to Involve page")

        sleep(5)
        logger.info("Waiting for page load")
        
        row = WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.CSS_SELECTOR, "tbody tr[role='row']:first-child"))
        )
        logger.info("Found first row in table")

        featured_switch = row.find_element(By.CSS_SELECTOR, "td:nth-child(5) input.featured")
        driver.execute_script("arguments[0].click();", featured_switch)
        logger.info("Toggled featured switch")
        
        status_switch = row.find_element(By.CSS_SELECTOR, "td:nth-child(6) input.status")
        driver.execute_script("arguments[0].click();", status_switch)
        logger.info("Toggled status switch")

        modal_button = row.find_element(By.CSS_SELECTOR, "td:last-child a[data-target='#involverequest5']")
        driver.execute_script("arguments[0].click();", modal_button)
        logger.info("Opened modal dialog")

        sleep(.75)

        select2_dropdown = WebDriverWait(driver, 10).until(
            EC.element_to_be_clickable((By.CSS_SELECTOR, "span.select2-selection--single"))
        )
        select2_dropdown.click()
        logger.info("Opened instructor dropdown")

        options = WebDriverWait(driver, 10).until(
            EC.presence_of_all_elements_located((By.CSS_SELECTOR, "li.select2-results__option"))
        )

        random_option = random.choice(options)
        selected_text = random_option.text
        random_option.click()
        logger.info(f"Selected instructor: {selected_text}")
        
        reason_textarea = driver.find_element(By.NAME, "reason")
        reason_textarea.send_keys("Automated reason for involvement request.")  
        logger.info("Entered reason for involvement")
        
        submit_button = WebDriverWait(driver, 10).until(
            EC.element_to_be_clickable((By.CSS_SELECTOR, ".modal-body form button[type='submit'][title='Update']"))
        )
        driver.execute_script("arguments[0].click();", submit_button)
        logger.info("Submitted form")

        success_info = (
            f"Edited instructor involvement request:\n"
            f"Instructor name: {selected_text}\n"
            f"Reason: Automated reason for involvement request.\n"
            f"Toggle changes: Featured/Status switched"
        )
        logger.info(success_info)

        print(Fore.GREEN + "Mengedit permintaan involvement instruktor :" + Fore.RESET)
        print(Fore.GREEN + f"Nama instructor : {selected_text}" + Fore.RESET)
        print(Fore.GREEN + f"Alasan : Automated reason for involvement request." + Fore.RESET)
        print(Fore.GREEN + f"Toggle (Featured / Status) : On -> Off / Off -> On" + Fore.RESET)

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