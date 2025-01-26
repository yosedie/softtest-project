from selenium import webdriver
from selenium.webdriver.edge.options import Options
from selenium.webdriver.edge.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from webdriver_manager.microsoft import EdgeChromiumDriverManager
import pytest
import time 

@pytest.fixture(scope="class")
def setup(request):
    options = Options()
    service = Service(EdgeChromiumDriverManager().install())
    driver = webdriver.Edge(service=service, options=options)

    try:
        driver.get("https://eclass.mediacity.co.in/demo/public/")
        driver.maximize_window()
        request.cls.driver = driver
        yield
    except Exception as e:
        print(f"An error occurred: {e}")
    finally:
        driver.quit()
        
@pytest.mark.usefixtures("setup")
class TestContact:
    def scroll_to_element(self, element):
        """Helper function to scroll to an element."""
        self.driver.execute_script("arguments[0].scrollIntoView({behavior: 'smooth', block: 'center'});", element)
        
    def test_handle_cookies_banner(self):
        cookies_button = WebDriverWait(self.driver, 5).until(
            EC.element_to_be_clickable((By.CSS_SELECTOR, ".js-cookie-consent-agree.cookie-consent__agree.cursor-pointer"))
        )
        cookies_button.click()
        time.sleep(5)
 
    def test_bukaContact(self):
        contact_link = WebDriverWait(self.driver, 10).until(
            EC.element_to_be_clickable((By.LINK_TEXT, "Contact"))
        )
        contact_link.click()
        
        time.sleep(5)
        
        
    def test_input_fields_and_submit(self):
        email_input = "dodo@gmail.com"
        phone_input = "123456788"
        name_input = "richard"
        message_input = "richard"

        # Fill email
        time.sleep(5)
        email_field = self.driver.find_element(By.ID, "email")
        time.sleep(5)
        self.scroll_to_element(email_field)
        email_field.send_keys(email_input)
        time.sleep(5)

        # Fill phone number
        phone_field = self.driver.find_element(By.ID, "mobile")
        phone_field.send_keys(phone_input)

        # Fill name
        name_field = self.driver.find_element(By.ID, "fname")
        name_field.send_keys(name_input)
        
        message_field = self.driver.find_element(By.ID, "comment")
        self.scroll_to_element(message_field)
        message_field.send_keys(message_input)
        time.sleep(5)

        # Submit form
        submit_button = WebDriverWait(self.driver, 10).until(
            EC.element_to_be_clickable((By.XPATH, '//*[@id="demo-form2"]/div/div[4]/div[2]/button'))
        )
        self.scroll_to_element(submit_button)
        submit_button.click()

    def test_alert_message(self):
        # Wait for the alert to appear
        alert = WebDriverWait(self.driver, 10).until(
            EC.visibility_of_element_located(
                (By.CSS_SELECTOR, ".offset-md-3.col-md-offset-3.col-md-6.animated.fadeInDown.alert.alert-success")
            )
        )
        self.scroll_to_element(alert)

        # Verify the alert text
        alert_text = alert.text
        assert "Request Successfully" in alert_text, f"Unexpected alert text: {alert_text}"
  
        
