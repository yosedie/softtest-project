import logging
import time
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.edge.service import Service
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import TimeoutException
from webdriver_manager.microsoft import EdgeChromiumDriverManager

# Setup Logging
logging.basicConfig(filename='test_log3yosedie.log', level=logging.INFO)
logger = logging.getLogger()

# Setup WebDriver for Edge
options = webdriver.EdgeOptions()
service = Service(EdgeChromiumDriverManager().install())
driver = webdriver.Edge(service=service, options=options)

def save_screenshot(driver, filename):
    """Saves a screenshot if the test fails."""
    timestamp = time.strftime("%Y%m%d-%H%M%S")
    screenshot_path = f"{filename}_{timestamp}.png"
    driver.save_screenshot(screenshot_path)
    logger.info(f"Screenshot saved to {screenshot_path}")

url = "https://eclass.mediacity.co.in/demo/public/instructor"

try:
    driver.get(url)
    driver.maximize_window()
    wait = WebDriverWait(driver, 20)

    # Login
    email_field = wait.until(EC.presence_of_element_located((By.NAME, "email")))
    password_field = wait.until(EC.presence_of_element_located((By.NAME, "password")))
    email_field.send_keys("instructor@mediacity.co.in")
    password_field.send_keys("123456")

    login_button = wait.until(EC.element_to_be_clickable((By.XPATH, "//button[@type='submit' and contains(@class, 'create-btn')]")))
    login_button.click()

    # Verify dashboard
    wait.until(EC.visibility_of_element_located((By.XPATH, "//h4[contains(text(),'Instructor Dashboard')]")))
    logger.info("Login Successful: Dashboard Loaded")
    time.sleep(2)

    try:
        blog_link = wait.until(EC.presence_of_element_located((By.XPATH, "//a[@href='https://eclass.mediacity.co.in/demo/public/blog']")))
        logger.info(f"Blog link found: {blog_link.get_attribute('outerHTML')}")
        driver.execute_script("arguments[0].click();", blog_link)
        logger.info("Successfully clicked on Blog icon.")
    except TimeoutException:
        logger.error("Timeout: Blog element not found.")
        save_screenshot(driver, "blog_timeout")
    except Exception as e:
        logger.error(f"Unexpected error: {e}")
        save_screenshot(driver, "blog_error")

    time.sleep(2)

    try:
        buttons = driver.find_elements(By.CSS_SELECTOR, "div.dt-buttons.btn-group a")
        for button in buttons:
            if "Print" not in button.text:
                time.sleep(1)
                button.click()
                logger.info(f"Successfully clicked on button: '{button.text}'")
    except Exception as e:
        logger.error(f"Error clicking buttons: {e}")
        save_screenshot(driver, "button_click_error")

    # Logout process
    profile_dropdown = wait.until(EC.visibility_of_element_located((By.XPATH, "//span[contains(text(),'Hi instructor')]")))
    time.sleep(1)
    driver.execute_script("arguments[0].click();", profile_dropdown)
    time.sleep(1)
    logout_button = wait.until(EC.element_to_be_clickable((By.XPATH, "//a[contains(text(),'Logout')]")))
    time.sleep(1)
    driver.execute_script("arguments[0].click();", logout_button)
    logger.info("Logout Successful")

except TimeoutException as e:
    logger.error(f"Timeout Error: {e}")
    save_screenshot(driver, "timeout_error")

except Exception as e:
    logger.error(f"Unexpected Error: {e}")
    save_screenshot(driver, "unexpected_error")

finally:
    # Wait to observe the result (optional)
    time.sleep(2)
    driver.quit()
