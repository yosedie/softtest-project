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
    def test_input(self):
        emailInput= "dodo@gmail.com"
        email_field = self.driver.find_element(By.ID, "email")
        self.driver.execute_script("arguments[0].scrollIntoView({behavior: 'smooth', block: 'center'});", email_field)
        time.sleep(5)
        email_field.send_keys(emailInput)    
        time.sleep(5)
        
        phoneInput= "123456788"
        phone_field = self.driver.find_element(By.ID, "mobile")
        phone_field.send_keys(phoneInput)    
        time.sleep(5)
        
        nameInput= "richard"
        name_field = self.driver.find_element(By.ID, "fname")
        name_field.send_keys(nameInput)    
        time.sleep(5)
        
        submit_link = WebDriverWait(self.driver, 10).until(
            EC.element_to_be_clickable((By.CLASS_NAME, "btn.ss-btn"))
        )
        self.driver.execute_script("arguments[0].scrollIntoView({behavior: 'smooth', block: 'center'});", submit_link)
        time.sleep(5)
        submit_link.click()
        time.sleep(5)
        
    def test_alert(self):
        alert=self.driver.find_element(By.CSS_SELECTOR, ".offset-md-3.col-md-offset-3.col-md-6.animated.fadeInDown.alert.alert-success")
        self.driver.execute_script("arguments[0].scrollIntoView({behavior: 'smooth', block: 'center'});", alert)
        time.sleep(5)
        if "Request Successfully" in alert.text:
            print("The alert contains the expected text.")
        else:
            print("The expected text was not found in the alert.")
        time.sleep(5)
        
  
        
