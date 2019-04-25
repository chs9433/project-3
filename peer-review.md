## P3 Peer Review

+ Reviewer's name: Christopher Sheppard
+ Reviwee's name: Michael S.
+ URL to Reviewee's P3 Github Repo URL: *<https://github.com/mpswain/p3>*

*Answer the following questions in regards to the student's project you are reviewing. REMOVE THE INSTRUCTIONS FOR EACH PROMPT when complete. We should only see YOUR ANSWERS.*

## 1. Interface
I was pleasantly surprised and impressed with the quality of the interface. The form layout is clear and concise with appropriate sizes and placement for most of the headers, helper text, and input labels/controls. The background is a nice touch that certainly reflects the focus of the form. I was also rather impressed with the design of your error and result-specific alerts and felt that they worked notably well; end-users will certainly appreciate error alerts appearing under the affecting input element.

I would recommend updating the UI to make the ‘(required)’ portion of each input label a little more conspicuous to the end-user. This can be done by changing the font weight to bold or changing the font color to red. The ‘Bonus’ checkbox control should align with the preceding questions to align with existing UI design-specific norms. I also suggest adding a ‘reset’ button and changing the alignment of all buttons to the right side of the form.



## 2. Functional testing
Your application’s overall functionality reflects its specified purpose.
A summary of tested scenarios is below:
•	Form submission with no inputs
•	Form submission with only some fields with values.
•	Form submission with negative and decimal number inputs.
•	Form submission with number inputs outside of the specified range.
•	GET requests to non-existent folders/location

While there are no parts of the interface that confused me, I initially expected the ‘operation’ radio field to auto-select a previous response upon validation failure of the ‘userNumber’ field. Upon further reflection, this may have been difficult given the prohibition of Javascript and/or the potential for confusion about the requirement to pre-fill form fields with problematic data (this can be misconstrued as pre-filling problematic data only upon validation failure).
I expected the ‘checkForPrime’ checkbox element to be pre-filled upon validation failure of any required form element as well.


## 3. Code: Routes
Your routes file was clear and concise with two explicit routes to your default page and ‘process’ logic method. The static placeholder for a future view route was a nice inclusion because it demonstrates your understanding of Laravel’s get and view routes – which I imagine can misunderstood by users new to the framework.  I didn’t find any code that should be in your MathController, either.

## 4. Code: Views
A majority of your view-specific code looks fine. Template inheritance is used and I found no egregious issues with your Blade syntax. I would recommend removing the ‘welcome.blade.php’ file since your default route points to ‘math.index’. The $title variables from the ‘title’ and ‘content’ sections of your ‘math.index’ view since the variable is not included/referenced in any of your MathController’s methods.
While there are no occurrences of non-display logic, I noticed that your ‘results’ div element consists of multiple if statements based on the ‘operator’ field. I recommend the following as an alternative approach to further simplify the display code in this section:
•	Update the value of your ‘operation’ input field to echo the HTML content (innerHTML) of each corresponding input label (i.e. id=’sqrt’ name=’operation’ value=’square root’)
•	Add a new variable (i.e ‘$operation_value’)  to your MathController’s process method that holds the result of either $squareRoot,$square, or $divisors based on your existing if statement. Be sure to update your index method with this variable as well.
•	Reduce the three operator-specific div/alert elements to just one by creating an innerHTML template that can accommodate any operator. An example is below based on the format of your existing alert messages:
<div class='alert alert-warning' role='alert'>
                        The {{ $operation }} of {{ $userNumber }} is {{ $operation_value }}.
                    </div>


## 5. Code: General
I found the code easy to understand and it aligned with the course’s coding style.

## 6. Misc
Bottom line is that this is a very polished application. The recommendations included in the above-mentioned sections are aimed at improving nuances of the UI. 
