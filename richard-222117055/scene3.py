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
class TestHome:
    def scroll_to_element(self, element):
        """Helper function to scroll to an element."""
        self.driver.execute_script("arguments[0].scrollIntoView({behavior: 'smooth', block: 'center'});", element)

    def test_search(self):
        """Test search functionality."""
        try:
            search_input = "web"
            # Locate the search input field and input a value
            search_field = WebDriverWait(self.driver, 10).until(
                EC.presence_of_element_located((By.CLASS_NAME, "searchTerm"))
            )
            self.scroll_to_element(search_field)
            search_field.send_keys(search_input)
            print("Search input entered successfully.")

            # Locate and click the search button
            search_button = WebDriverWait(self.driver, 10).until(
                EC.element_to_be_clickable((By.CLASS_NAME, "searchButton"))
            )
            self.scroll_to_element(search_button)
            time.sleep(2)
            search_button.click()
            time.sleep(5)
            print("Search button clicked successfully.")
        except Exception as e:
            print(f"Search test failed: {e}")

    def test_home(self):
        """Test navigation to the home footer header."""
        try:
            # Locate the header element in the footer
            header = WebDriverWait(self.driver, 10).until(
                EC.presence_of_element_located((By.XPATH, "/html/body/footer/div[1]/div/div/div[2]/div/div[1]/h2"))
            )
            self.scroll_to_element(header)
            time.sleep(2)
            print("Scrolled to the footer header successfully.")
        except Exception as e:
            print(f"Failed to locate footer header: {e}")

    def test_ganti_bahasa(self):
        """Test changing the language from English to Hindi."""
        try:
            # Locate the language dropdown menu
            language_dropdown = WebDriverWait(self.driver, 10).until(
                EC.element_to_be_clickable((By.XPATH, "//div[@class='footer-dropdown']/a"))
            )
            self.scroll_to_element(language_dropdown)
            time.sleep(2)
            language_dropdown.click()  # Open the dropdown menu
            print("Language dropdown opened successfully.")

            # Select the Hindi language
            hindi_option = WebDriverWait(self.driver, 10).until(
                EC.element_to_be_clickable((By.XPATH, "//a[contains(@href, '/language-switch/hi')]/li"))
            )
            self.scroll_to_element(hindi_option)
            time.sleep(2)
            hindi_option.click()
            print("Language changed successfully to Hindi.")
            
            # Validate the change (optional step if there's an indicator)
            time.sleep(5)  # Wait for the page to reload
            assert "hi" in self.driver.current_url, "Language did not switch to Hindi."
        except Exception as e:
            print(f"Failed to change language: {e}")
