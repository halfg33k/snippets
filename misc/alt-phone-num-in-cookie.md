# Storing an Alternate Phone Number in a Cookie   

**Use Case:** My client wants to have separate phone numbers for each ad campaign. 
Each campaign should also have a unique landing page. I need that number to persist throughout the site 
even if the user exits the browser.    

I'm assuming each landing page has an alternate version of the header with the ad-specific phone number
(whether hard coded or populated using `php`). 



**This is a simple cookie script that can be found at the following url:**
[https://www.quirksmode.org/js/cookies.html](https://www.quirksmode.org/js/cookies.html)    
It can be used as-is. This is in pure `javascript` but the rest will be in `jQuery` because that's what I was using at the time.


```javascript
function createCookie(name,value,days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        var expires = "; expires="+date.toGMTString();
    }
    else var expires = "";
    document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

function eraseCookie(name) {
    createCookie(name,"",-1);
}
```

## Creating the Cookie

There are two variables at play.
1) The phone number itself
2) whether we are currently on the page that needs to create the cookie (e.g. an ad landing page)

In this case, we will retrieve the phone number from the header.
```javascript
$phone = $( '.header__phone a' );
```

Now we need to determine whether this is the ad landing page. We can easily achieve this by setting a data-attribute on the phone number element. This example has `data-adphone=1` if this is a landing page, and `data-adphone=0` otherwise.
```javascript
$isAdPage = $phone.data( 'adphone' );
```

Now, we can create a cookie whenever someone lands on this page.
```javascript
if( $isAdPage ) {
    createCookie( 'adPhone', $phone.text(), 45 );
}
```
The above code will check if this is an ad page. If it is, we create a cookie called "adPhone" with a value of whatever phone number we found in the header and set it to expire in 45 days.    

## Reading the Cookie
If someone has hit one of our ad pages, we want them to see that number whenever they go to another part of our site.    

We start by reading the cookie we previously created. If the cookie exists, they've been to one of our ad pages. Then, we set the text and the `href` of the header phone number field to the value found in the cookie.

```javascript
if( readCookie( 'adPhone' ) ) {
    $phone.text( readCookie( 'adPhone' ) );
    $phone.attr( 'href', 'tel:' + readCookie( 'adPhone' ) );
}
```
