import logging
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.edge.service import Service
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import TimeoutException, NoSuchElementException
from webdriver_manager.microsoft import EdgeChromiumDriverManager
import time

# Setup Logging
logging.basicConfig(filename='test_log4yosedie.log', level=logging.INFO, format='%(asctime)s - %(levelname)s - %(message)s')

class TestAutomation:
    def __init__(self):
        # Setup WebDriver for Edge
        options = webdriver.EdgeOptions()
        service = Service(EdgeChromiumDriverManager().install())
        self.driver = webdriver.Edge(service=service, options=options)

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
            wait = WebDriverWait(self.driver, 20)

            # Login
            email_field = wait.until(EC.presence_of_element_located((By.NAME, "email")))
            password_field = wait.until(EC.presence_of_element_located((By.NAME, "password")))
            email_field.send_keys("instructor@mediacity.co.in")
            password_field.send_keys("123456")

            login_button = wait.until(EC.element_to_be_clickable((By.XPATH, "//button[@type='submit' and contains(@class, 'create-btn')]")))
            login_button.click()

            # Verify dashboard
            wait.until(EC.visibility_of_element_located((By.XPATH, "//h4[contains(text(),'Instructor Dashboard')]")))
            logging.info("Login Successful: Dashboard Loaded")
            time.sleep(2)

            # Tunggu hingga elemen dengan icon "Blog" tersedia
            try:
                blog_link = wait.until(EC.presence_of_element_located((By.XPATH, "//a[@href='https://eclass.mediacity.co.in/demo/public/blog']")))
                logging.info(f"Blog link found: {blog_link.get_attribute('outerHTML')}")
                self.driver.execute_script("arguments[0].click();", blog_link)
                logging.info("Berhasil menekan ikon Blog.")
            except TimeoutException:
                logging.error("Timeout: Tidak menemukan elemen Blog.")
                self.save_screenshot("error_blog_link")
            except Exception as e:
                logging.error(f"Error: {e}")
                self.save_screenshot("error_blog_link")

            time.sleep(2)

            # Klik checkbox jika tersedia
            try:
                checkbox = wait.until(EC.element_to_be_clickable((By.CSS_SELECTOR, "td[tabindex='0'] input[type='checkbox']")))
                checkbox.click()
                logging.info("Checkbox berhasil diklik.")
            except NoSuchElementException:
                logging.error("Checkbox tidak ditemukan.")
                self.save_screenshot("error_checkbox")
            except Exception as e:
                logging.error(f"Terjadi error: {e}")
                self.save_screenshot("error_checkbox")

            # Klik tombol "Delete Selected" jika tersedia
            try:
                delete_button = wait.until(EC.element_to_be_clickable((By.CSS_SELECTOR, "button[data-target='#bulk_delete']")))
                delete_button.click()
                time.sleep(1)
                logging.info("Tombol 'Delete Selected' berhasil diklik.")
            except NoSuchElementException:
                logging.error("Tombol 'Delete Selected' tidak ditemukan.")
                self.save_screenshot("error_delete_button")
            except Exception as e:
                logging.error(f"Terjadi error: {e}")
                self.save_screenshot("error_delete_button")

            # Klik tombol "Yes" untuk konfirmasi
            try:
                yes_button = wait.until(EC.element_to_be_clickable((By.CSS_SELECTOR, "form#bulk_delete_form button.btn.btn-danger")))
                yes_button.click()
                logging.info("Tombol 'Yes' berhasil diklik.")
            except NoSuchElementException:
                logging.error("Tombol 'Yes' tidak ditemukan.")
                self.save_screenshot("error_yes_button")
            except Exception as e:
                logging.error(f"Terjadi error: {e}")
                self.save_screenshot("error_yes_button")

            # Logout
            try:
                profile_dropdown = wait.until(EC.visibility_of_element_located((By.XPATH, "//span[contains(text(),'Hi instructor')]")))
                time.sleep(1)
                self.driver.execute_script("arguments[0].click();", profile_dropdown)
                time.sleep(1)
                logout_button = wait.until(EC.element_to_be_clickable((By.XPATH, "//a[contains(text(),'Logout')]")))
                time.sleep(1)
                self.driver.execute_script("arguments[0].click();", logout_button)
                logging.info("Logout Successful")
            except Exception as e:
                logging.error(f"Terjadi error saat logout: {e}")
                self.save_screenshot("error_logout")

        except TimeoutException as e:
            logging.error(f"Timeout Error: {e}")
            self.save_screenshot("timeout_error")

        except Exception as e:
            logging.error(f"Unexpected Error: {e}")
            self.save_screenshot("unexpected_error")

        finally:
            # Wait to observe the result (optional)
            time.sleep(2)
            self.driver.quit()

# Running the test
test = TestAutomation()
test.run_test()
