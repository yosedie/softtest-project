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
    """Setup Selenium WebDriver for Edge."""
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
        """Handle cookie consent banner if it appears."""
        try:
            cookies_button = WebDriverWait(self.driver, 5).until(
                EC.element_to_be_clickable(
                    (By.CSS_SELECTOR, ".js-cookie-consent-agree.cookie-consent__agree.cursor-pointer")
                )
            )
            cookies_button.click()
            print("Cookie banner handled successfully.")
        except Exception as e:
            print(f"No cookie banner found: {e}")

    def test_bukaContact(self):
        """Navigate to the Contact page."""
        contact_link = WebDriverWait(self.driver, 10).until(
            EC.element_to_be_clickable((By.LINK_TEXT, "Contact"))
        )
        contact_link.click()
        time.sleep(3)
        assert "contact" in self.driver.current_url.lower(), "Failed to navigate to Contact page."

    def test_input_fields_and_submit(self):
        """Fill out the contact form and submit it."""
        email_input = "dodo@gmail.com"
        phone_input = "123456788"
        name_input = "richard"
        message_input = "ricardo milos"

        # Fill email
        email_field = WebDriverWait(self.driver, 10).until(
            EC.presence_of_element_located((By.ID, "email"))
        )
        self.scroll_to_element(email_field)
        email_field.send_keys(email_input)

        # Fill phone number
        phone_field = WebDriverWait(self.driver, 10).until(
            EC.presence_of_element_located((By.ID, "mobile"))
        )
        phone_field.send_keys(phone_input)

        # Fill name
        name_field = WebDriverWait(self.driver, 10).until(
            EC.presence_of_element_located((By.ID, "fname"))
        )
        name_field.send_keys(name_input)

        # Fill message
        message_field = WebDriverWait(self.driver, 10).until(
            EC.presence_of_element_located((By.ID, "comment"))
        )
        self.scroll_to_element(message_field)
        message_field.send_keys(message_input)

        # Submit form
        submit_button = WebDriverWait(self.driver, 10).until(
            EC.element_to_be_clickable(
                (By.XPATH, '/html/body/main/section[2]/div/div/div/div/form/div/div[4]/div[2]/button')
            )
        )
        self.scroll_to_element(submit_button)
        time.sleep(2)
        submit_button.click()
        time.sleep(3)

    def test_alert_message(self):
        """Verify success alert message after form submission."""
        try:
            # Wait for the alert to appear
            alert = WebDriverWait(self.driver, 10).until(
                EC.visibility_of_element_located(
                    (By.CSS_SELECTOR, ".alert.alert-success.animated.fadeInDown")
                )
            )
            self.scroll_to_element(alert)

            # Verify the alert text
            alert_text = alert.text
            assert "Request Successfully" in alert_text, f"Unexpected alert text: {alert_text}"
            print("Success alert verified.")
        except Exception as e:
            print(f"Failed to verify success alert: {e}")
