<template>
    <div>
        <!-- error start -->
         <div class="error-outer">
          	<div class="error">
  	         	<h1>404!</h1>
  	         	<h4>
                    {{ translate('frontstaticword.OopsPageNotFound')}}       
                </h4>
  	         	<p>
                    {{ translate('frontstaticword.Thepageyouwerelookingforcouldnotbefound')}}.
                </p>
              <div class="start-btn mt-3">
                <router-link class="m-0" :to="{name: 'home'}">
                    {{ translate('frontstaticword.ReturnHome')}}
                </router-link>
              </div>
  	        </div>
          </div>
         <!-- error end -->
    </div>
</template>
