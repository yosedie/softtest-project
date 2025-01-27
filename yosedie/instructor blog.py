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
logging.basicConfig(filename='test_log2yosedie.log', level=logging.INFO, format='%(asctime)s - %(levelname)s - %(message)s')

class WebTest:
    def __init__(self):
        # Setup WebDriver for Edge
        options = webdriver.EdgeOptions()
        service = Service(EdgeChromiumDriverManager().install())
        self.driver = webdriver.Edge(service=service, options=options)
        self.wait = WebDriverWait(self.driver, 20)

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

            # Blog Icon Test
            try:
                blog_link = self.wait.until(EC.presence_of_element_located((By.XPATH, "//a[@href='https://eclass.mediacity.co.in/demo/public/blog']")))
                logging.info(f"Blog link found: {blog_link.get_attribute('outerHTML')}")
                self.driver.execute_script("arguments[0].click();", blog_link)
                logging.info("Blog Icon Clicked")
            except TimeoutException as e:
                logging.error("Timeout: Blog Icon not found")
                self.save_screenshot("blog_icon_error")

            time.sleep(2)
            # Add Post Button Test
            try:
                add_post_button = self.wait.until(EC.presence_of_element_located((By.XPATH, "//a[@href='https://eclass.mediacity.co.in/demo/public/blog/create']")))
                self.driver.execute_script("arguments[0].scrollIntoView(true);", add_post_button)
                logging.info(f"Add Post Button found: {add_post_button.get_attribute('outerHTML')}")
                self.driver.execute_script("arguments[0].click();", add_post_button)
                logging.info("Add Post Button Clicked")
            except TimeoutException as e:
                logging.error("Timeout: Add Post Button not found")
                self.save_screenshot("add_post_button_error")

            time.sleep(2)

            # Form Submission
            try:
                self.wait.until(EC.presence_of_element_located((By.XPATH, "//input[@id='heading']")))
                
                # Fill out form fields
                self.driver.find_element(By.ID, "heading").send_keys("My New Blog Post0")
                self.driver.find_element(By.ID, "slug").send_keys("my-new-blog-post0")
                self.driver.find_element(By.NAME, "text").send_keys("Read More0")
                self.driver.find_element(By.ID, "inputDate").send_keys("01/27/2025")
                self.driver.find_element(By.ID, "inputGroupFile01").send_keys(r"C:\test.jpg")  # Adjust path as necessary
                
                # Switch to iframe for editor
                iframe = self.driver.find_element(By.ID, "detail_ifr")
                self.driver.switch_to.frame(iframe)
                self.driver.find_element(By.CSS_SELECTOR, "body").send_keys("This is a detailed description of my new blog post.0")
                self.driver.switch_to.default_content()

                # Click Create button
                self.driver.find_element(By.XPATH, "//button[@type='submit' and contains(text(), 'Create')]").click()
                logging.info("Form successfully filled and submitted")
            except Exception as e:
                logging.error(f"Error during form submission: {e}")
                self.save_screenshot("form_submission_error")

            # Logout
            profile_dropdown = self.wait.until(EC.visibility_of_element_located((By.XPATH, "//span[contains(text(),'Hi instructor')]")))
            self.driver.execute_script("arguments[0].click();", profile_dropdown)
            time.sleep(2)
            logout_button = self.wait.until(EC.element_to_be_clickable((By.XPATH, "//a[contains(text(),'Logout')]")))
            self.driver.execute_script("arguments[0].click();", logout_button)
            logging.info("Logout Successful")

        except TimeoutException as e:
            logging.error(f"Timeout Error: {e}")
            self.save_screenshot("timeout_error")

        except Exception as e:
            logging.error(f"Unexpected Error: {e}")
            self.save_screenshot("unexpected_error")

        finally:
            time.sleep(2)
            self.driver.quit()

# Initialize and run the test
test = WebTest()
test.run_test()
