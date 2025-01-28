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
    log_filename = os.path.join('logs', f'verifyUser_{timestamp}.log')
    
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
    logger.info(f"Starting Verify User test - Log file: {log_filename}")
    try:
        logger.info("Starting Verify User test")
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
        
        verify_user_link = submenu.find_element(By.XPATH, ".//a[normalize-space()='Verify User']")
        verify_user_link.click()
        logger.info("Navigated to Verify User page")

        sleep(0.5)

        last_page = WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.XPATH, "//ul[@class='pagination']/li[last()-1]/a"))
        )
        last_page.click()
        logger.info("Clicked last page button")

        sleep(2)
        
        driver.execute_script("window.scrollTo(0, document.body.scrollHeight);")
        WebDriverWait(driver, 5).until(lambda d: d.execute_script("return (window.innerHeight + window.scrollY) >= document.body.scrollHeight"))
        logger.info("Scrolled to the bottom of the page")
        
        first_row = WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.XPATH, "//table/tbody/tr[1]"))
        )
        logger.info("First row table loaded")
                    
        view_button = first_row.find_element(By.XPATH, ".//button[@title='View']")
        view_button.click()
        logger.info("Clicked view button")

        modal_footer = WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.CLASS_NAME, "modal-footer"))
        )
        logger.info("Modal footer loaded")

        verify_button = modal_footer.find_element(By.CSS_SELECTOR, "button.btn-success a.text-white")
        driver.execute_script("arguments[0].scrollIntoView(true);", verify_button)
        logger.info("Scroll to the button")

        driver.implicitly_wait(1)
        driver.execute_script("arguments[0].click();", verify_button)
        logger.info("Clicked verify button")

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