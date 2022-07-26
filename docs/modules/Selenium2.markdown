---
layout: doc
title: Codeception - Documentation
---

# Selenium2 Module
**For additional reference, please review the [source](https://github.com/Codeception/Codeception/tree/master/src/Codeception/Module/Selenium2.php)**


Uses Mink to manipulate Selenium2 WebDriver

Note that all method take CSS selectors to fetch elements.

On test failure the browser window screenshot will be saved to log directory

### Installation

Download [Selenium2 WebDriver](https://code.google.com/p/selenium/downloads/list?q=selenium-server-standalone-2)
Launch the daemon: `java -jar selenium-server-standalone-2.xx.xxx.jar`

Don't forget to turn on Db repopulation if you are using database.

### Status

* Maintainer: **davert**
* Stability: **stable**
* Contact: codecept@davert.mail.ua
* relies on [Mink](https://mink.behat.org)

### Configuration

* url *required* - start url for your app
* browser *required* - browser that would be launched
* host  - Selenium server host (localhost by default)
* port - Selenium server port (4444 by default)
* delay - set delay between actions in milliseconds (1/1000 of second) if they run too fast
* capabilities - sets Selenium2 [desired capabilities](https://code.google.com/p/selenium/wiki/DesiredCapabilities). Should be a key-value array.

#### Example (`acceptance.suite.yml`)

    modules:
       enabled: [Selenium2]
       config:
          Selenium2:
             url: 'http://localhost/'
             browser: firefox
             capabilities:
                 unexpectedAlertBehaviour: 'accept'

### Public Properties

* session - contains Mink Session
* webDriverSession - contains webDriverSession object, i.e. $session from [php-webdriver](https://github.com/facebook/php-webdriver)

### Actions


#### acceptPopup


Accept alert or confirm popup

Example:
{% highlight php %}

<?php
$I->click('Show alert popup');
$I->acceptPopup();


{% endhighlight %}


#### amOnPage


Opens the page.

 * param $page


#### amOnSubdomain


Sets 'url' configuration parameter to hosts subdomain.
It does not open a page on subdomain. Use `amOnPage` for that

{% highlight php %}

<?php
// If config is: 'http://mysite.com'
// or config is: 'http://www.mysite.com'
// or config is: 'http://company.mysite.com'

$I->amOnSubdomain('user');
$I->amOnPage('/');
// moves to http://user.mysite.com/
?>

{% endhighlight %}
 * param $subdomain
 * return mixed


#### attachFile


Attaches file from Codeception data directory to upload field.

Example:

{% highlight php %}

<?php
// file is stored in 'tests/data/tests.xls'
$I->attachFile('prices.xls');
?>

{% endhighlight %}

 * param $field
 * param $filename


#### blur


Removes focus from link or button or any node found by CSS or XPath
XPath or CSS selectors are accepted.

 * param $el


#### cancelPopup


Dismiss alert or confirm popup

Example:
{% highlight php %}

<?php
$I->click('Show confirm popup');
$I->cancelPopup();


{% endhighlight %}


#### checkOption


Ticks a checkbox.
For radio buttons use `selectOption` method.

Example:

{% highlight php %}

<?php
$I->checkOption('#agree');
?>

{% endhighlight %}

 * param $option


#### click


Perform a click on link or button.
Link or button are found by their names or CSS selector.
Submits a form if button is a submit type.

If link is an image it's found by alt attribute value of image.
If button is image button is found by it's value
If link or button can't be found by name they are searched by CSS selector.

The second parameter is a context: CSS or XPath locator to narrow the search.

Examples:

{% highlight php %}

<?php
// simple link
$I->click('Logout');
// button of form
$I->click('Submit');
// CSS button
$I->click('#form input[type=submit]');
// XPath
$I->click('//form/*[@type=submit]')
// link in context
$I->click('Logout', '#nav');
?>

{% endhighlight %}
 * param $link
 * param $context


#### clickWithRightButton


Clicks with right button on link or button or any node found by CSS or XPath

 * param $link


#### dontSee


Check if current page doesn't contain the text specified.
Specify the css selector to match only specific region.

Examples:

{% highlight php %}

<?php
$I->dontSee('Login'); // I can suppose user is already logged in
$I->dontSee('Sign Up','h1'); // I can suppose it's not a signup page
$I->dontSee('Sign Up','//body/h1'); // with XPath

{% endhighlight %}

 * param $text
 * param null $selector


#### dontSeeCheckboxIsChecked


Assert if the specified checkbox is unchecked.
Use css selector or xpath to match.

Example:

{% highlight php %}

<?php
$I->dontSeeCheckboxIsChecked('#agree'); // I suppose user didn't agree to terms
$I->seeCheckboxIsChecked('#signup_form input[type=checkbox]'); // I suppose user didn't check the first checkbox in form.


{% endhighlight %}

 * param $checkbox


#### dontSeeCookie

__not documented__


#### dontSeeCurrentUrlEquals


Checks that current url is not equal to value.
Unlike `dontSeeInCurrentUrl` performs a strict check.

<?php
// current url is not root
$I->dontSeeCurrentUrlEquals('/');
?>

 * param $uri


#### dontSeeCurrentUrlMatches


Checks that current url does not match a RegEx value

<?php
// to match root url
$I->dontSeeCurrentUrlMatches('~$/users/(\d+)~');
?>

 * param $uri


#### dontSeeElement


Checks if element does not exist (or is visible) on a page, matching it by CSS or XPath

{% highlight php %}

<?php
$I->dontSeeElement('.error');
$I->dontSeeElement(//form/input[1]);
?>

{% endhighlight %}
 * param $selector


#### dontSeeInCurrentUrl


Checks that current uri does not contain a value

{% highlight php %}

<?php
$I->dontSeeInCurrentUrl('/users/');
?>

{% endhighlight %}

 * param $uri


#### dontSeeInField


Checks that an input field or textarea doesn't contain value.
Field is matched either by label or CSS or Xpath
Example:

{% highlight php %}

<?php
$I->dontSeeInField('Body','Type your comment here');
$I->dontSeeInField('form textarea[name=body]','Type your comment here');
$I->dontSeeInField('form input[type=hidden]','hidden_value');
$I->dontSeeInField('#searchform input','Search');
$I->dontSeeInField('//form/*[@name=search]','Search');
?>

{% endhighlight %}

 * param $field
 * param $value


#### dontSeeInPopup


Check if popup don't contains the $text

Example:
{% highlight php %}

<?php
$I->click();
$I->dontSeeInPopup('Error message');


{% endhighlight %}

 * param string $text


#### dontSeeLink


Checks if page doesn't contain the link with text specified.
Specify url to narrow the results.

Examples:

{% highlight php %}

<?php
$I->dontSeeLink('Logout'); // I suppose user is not logged in


{% endhighlight %}

 * param $text
 * param null $url


#### dontSeeOptionIsSelected


Checks if option is not selected in select field.

{% highlight php %}

<?php
$I->dontSeeOptionIsSelected('#form input[name=payment]', 'Visa');
?>

{% endhighlight %}

 * param $selector
 * param $optionText
 * return mixed


#### doubleClick


Double clicks on link or button or any node found by CSS or XPath

 * param $link


#### dragAndDrop


Drag first element to second
XPath or CSS selectors are accepted.

 * param $el1
 * param $el2


#### executeInSelenium


Low-level API method.
If Codeception commands are not enough, use Selenium WebDriver methods directly

{% highlight php %}

$I->executeInSelenium(function(\WebDriver\Session $webdriver) {
  $webdriver->back();
});

{% endhighlight %}

Use [WebDriver Session API](https://github.com/facebook/php-webdriver)
Not recommended this command too be used on regular basis.
If Codeception lacks important Selenium methods implement then and submit patches.

 * param callable $function


#### executeJs


Executes any JS code.

 * param $jsCode


#### fillField


Fills a text field or textarea with value.

 * param $field
 * param $value


#### focus


Moves focus to link or button or any node found by CSS or XPath

 * param $el


#### grabAttribute

__not documented__


#### grabCookie

__not documented__


#### grabFromCurrentUrl


Takes a parameters from current URI by RegEx.
If no url provided returns full URI.

{% highlight php %}

<?php
$user_id = $I->grabFromCurrentUrl('~$/user/(\d+)/~');
$uri = $I->grabFromCurrentUrl();
?>

{% endhighlight %}

 * param null $uri
 * internal param $url
 * return mixed


#### grabTextFrom


Finds and returns text contents of element.
Element is searched by CSS selector, XPath or matcher by regex.

Example:

{% highlight php %}

<?php
$heading = $I->grabTextFrom('h1');
$heading = $I->grabTextFrom('descendant-or-self::h1');
$value = $I->grabTextFrom('~<input value=(.*?)]~sgi');
?>

{% endhighlight %}

 * param $cssOrXPathOrRegex
 * return mixed


#### grabValueFrom


Finds and returns field and returns it's value.
Searches by field name, then by CSS, then by XPath

Example:

{% highlight php %}

<?php
$name = $I->grabValueFrom('Name');
$name = $I->grabValueFrom('input[name=username]');
$name = $I->grabValueFrom('descendant-or-self::form/descendant::input[@name = 'username']');
?>

{% endhighlight %}

 * param $field
 * return mixed


#### moveBack


Moves back in history


#### moveForward


Moves forward in history


#### moveMouseOver


Moves mouse over link or button or any node found by CSS or XPath

 * param $link


#### pressKey


Presses key on element found by css, xpath is focused
A char and modifier (ctrl, alt, shift, meta) can be provided.

Example:

{% highlight php %}

<?php
$I->pressKey('#page','u');
$I->pressKey('#page','u','ctrl');
$I->pressKey('descendant-or-self::*[@id='page']','u');
?>

{% endhighlight %}

 * param $element
 * param $char char can be either char ('b') or char-code (98)
 * param null $modifier keyboard modifier (could be 'ctrl', 'alt', 'shift' or 'meta')


#### pressKeyDown


Presses key down on element found by CSS or XPath.

For example see 'pressKey'.

 * param $element
 * param $char char can be either char ('b') or char-code (98)
 * param null $modifier keyboard modifier (could be 'ctrl', 'alt', 'shift' or 'meta')


#### pressKeyUp


Presses key up on element found by CSS or XPath.

For example see 'pressKey'.

 * param $element
 * param $char char can be either char ('b') or char-code (98)
 * param null $modifier keyboard modifier (could be 'ctrl', 'alt', 'shift' or 'meta')


#### reloadPage


Reloads current page


#### resetCookie

__not documented__


#### resizeWindow


Resize current window

Example:
{% highlight php %}

<?php
$I->resizeWindow(800, 600);


{% endhighlight %}

 * param int    $width
 * param int    $height
 * author Jaik Dean <jaik@jaikdean.com>


#### see


Check if current page contains the text specified.
Specify the css selector to match only specific region.

Examples:

{% highlight php %}

<?php
$I->see('Logout'); // I can suppose user is logged in
$I->see('Sign Up','h1'); // I can suppose it's a signup page
$I->see('Sign Up','//body/h1'); // with XPath


{% endhighlight %}

 * param $text
 * param null $selector


#### seeCheckboxIsChecked


Assert if the specified checkbox is checked.
Use css selector or xpath to match.

Example:

{% highlight php %}

<?php
$I->seeCheckboxIsChecked('#agree'); // I suppose user agreed to terms
$I->seeCheckboxIsChecked('#signup_form input[type=checkbox]'); // I suppose user agreed to terms, If there is only one checkbox in form.
$I->seeCheckboxIsChecked('//form/input[@type=checkbox and  * name=agree]');


{% endhighlight %}

 * param $checkbox


#### seeCookie

__not documented__


#### seeCurrentUrlEquals


Checks that current url is equal to value.
Unlike `seeInCurrentUrl` performs a strict check.

<?php
// to match root url
$I->seeCurrentUrlEquals('/');
?>

 * param $uri


#### seeCurrentUrlMatches


Checks that current url is matches a RegEx value

<?php
// to match root url
$I->seeCurrentUrlMatches('~$/users/(\d+)~');
?>

 * param $uri


#### seeElement


Checks element visibility.
Fails if element exists but is invisible to user.
Eiter CSS or XPath can be used.

 * param $selector


#### seeInCurrentUrl


Checks that current uri contains a value

{% highlight php %}

<?php
// to match: /home/dashboard
$I->seeInCurrentUrl('home');
// to match: /users/1
$I->seeInCurrentUrl('/users/');
?>

{% endhighlight %}

 * param $uri


#### seeInField


Checks that an input field or textarea contains value.
Field is matched either by label or CSS or Xpath

Example:

{% highlight php %}

<?php
$I->seeInField('Body','Type your comment here');
$I->seeInField('form textarea[name=body]','Type your comment here');
$I->seeInField('form input[type=hidden]','hidden_value');
$I->seeInField('#searchform input','Search');
$I->seeInField('//form/*[@name=search]','Search');
?>

{% endhighlight %}

 * param $field
 * param $value


#### seeInPopup


Checks if popup contains the $text

Example:
{% highlight php %}

<?php
$I->click('Show alert popup');
$I->seeInPopup('Error message');


{% endhighlight %}

 * param string $text


#### seeLink


Checks if there is a link with text specified.
Specify url to match link with exact this url.

Examples:

{% highlight php %}

<?php
$I->seeLink('Logout'); // matches <a href="#">Logout</a>
$I->seeLink('Logout','/logout'); // matches <a href="/logout">Logout</a>


{% endhighlight %}

 * param $text
 * param null $url


#### seeOptionIsSelected


Checks if option is selected in select field.

{% highlight php %}

<?php
$I->seeOptionIsSelected('#form input[name=payment]', 'Visa');
?>

{% endhighlight %}

 * param $selector
 * param $optionText
 * return mixed


#### selectOption


Selects an option in select tag or in radio button group.

Example:

{% highlight php %}

<?php
$I->selectOption('form select[name=account]', 'Premium');
$I->selectOption('form input[name=payment]', 'Monthly');
$I->selectOption('//form/select[@name=account]', 'Monthly');
?>

{% endhighlight %}

 * param $select
 * param $option


#### setCookie

__not documented__


#### switchToIFrame


Switch to another frame

Example:
{% highlight html %}

<iframe name="another_frame" src="http://example.com">


{% endhighlight %}

{% highlight php %}

<?php
# switch to iframe
$I->switchToIFrame("another_frame");
# switch to parent page
$I->switchToIFrame();


{% endhighlight %}

 * param string|null $name


#### switchToWindow


Switch to another window

Example:
{% highlight html %}

<input type="button" value="Open window" onclick="window.open('http://example.com', 'another_window')">


{% endhighlight %}

{% highlight php %}

<?php
$I->click("Open window");
# switch to another window
$I->switchToWindow("another_window");
# switch to parent window
$I->switchToWindow();


{% endhighlight %}

 * param string|null $name


#### uncheckOption


Unticks a checkbox.

Example:

{% highlight php %}

<?php
$I->uncheckOption('#notify');
?>

{% endhighlight %}

 * param $option


#### wait


Wait for x milliseconds

 * param $milliseconds


#### waitForJS


Waits for x milliseconds or until JS condition turns true.

 * param $milliseconds
 * param $jsCondition
