import logging
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.edge.service import Service
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import TimeoutException
from webdriver_manager.microsoft import EdgeChromiumDriverManager
import time

# Setup logging
logging.basicConfig(filename='test_log1yosedie.log', level=logging.INFO, format='%(asctime)s - %(levelname)s - %(message)s')

class WebTest:
    def __init__(self):
        # Setup WebDriver for Edge
        options = webdriver.EdgeOptions()
        service = Service(EdgeChromiumDriverManager().install())
        self.driver = webdriver.Edge(service=service, options=options)
        self.wait = WebDriverWait(self.driver, 30)

    def save_screenshot(self, filename):
        """Saves a screenshot if the test fails."""
        timestamp = time.strftime("%Y%m%d-%H%M%S")
        screenshot_path = f"{filename}_{timestamp}.png"
        self.driver.save_screenshot(screenshot_path)
        logging.info(f"Screenshot saved to {screenshot_path}")

    def run_test(self):
        url = "https://eclass.mediacity.co.in/demo/public/instructor"
        try:
            self.driver.get(url)
            self.driver.maximize_window()

            # Login
            email_field = self.wait.until(EC.presence_of_element_located((By.NAME, "email"))).send_keys("instructor@mediacity.co.in")
            password_field = self.wait.until(EC.presence_of_element_located((By.NAME, "password"))).send_keys("123456")

            login_button = self.wait.until(EC.element_to_be_clickable((By.XPATH, "//button[@type='submit' and contains(@class, 'create-btn')]"))).click()

            # Verify dashboard
            self.wait.until(EC.visibility_of_element_located((By.XPATH, "//h4[contains(text(),'Instructor Dashboard')]")))
            logging.info("Login Successful: Dashboard Loaded")
            
            # Language change test
            dropdownh = self.wait.until(EC.element_to_be_clickable((By.ID, "languagelink"))).click()
            hindi_option = self.wait.until(EC.element_to_be_clickable((By.LINK_TEXT, "Hindi (hi)"))).click()

            # Change back to English
            dropdowne = self.wait.until(EC.element_to_be_clickable((By.ID, "languagelink"))).click()
            english_option = self.wait.until(EC.element_to_be_clickable((By.LINK_TEXT, "English (en)"))).click()

            logging.info("Language changed and reverted back successfully.")

            # Toggle Button Test
            toggle_button = self.wait.until(EC.element_to_be_clickable((By.ID, "modeSwitch1")))
            toggle_button.click()
            time.sleep(1)
            toggle_button.click()
            logging.info("Toggle button clicked twice successfully.")

            # Logout process
            profile_dropdown = self.wait.until(EC.visibility_of_element_located((By.XPATH, "//span[contains(text(),'Hi instructor')]")))
            self.driver.execute_script("arguments[0].click();", profile_dropdown)

            logout_button = self.wait.until(EC.element_to_be_clickable((By.XPATH, "//a[contains(text(),'Logout')]")))
            self.driver.execute_script("arguments[0].click();", logout_button)
            logging.info("Logout Successful")

        except TimeoutException as e:
            logging.error(f"Timeout Error: {e}")
            self.save_screenshot('timeout_error')

        except Exception as e:
            logging.error(f"Unexpected Error: {e}")
            self.save_screenshot('unexpected_error')

        finally:
            time.sleep(2)
            self.driver.quit()

# Initialize and run the test
test = WebTest()
test.run_test()
