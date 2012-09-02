<h1>Data segment too large error</h1>
<div class="date">01.01.2007</div>


<p>When I add a large number of typed constants to my application, my data segment grows too large. How can I get around this?</p>
<p>Typed constants are added to the Program's data segment. Untyped constants are added to the code segment of the application only if they are used. Unless you are going to reassign the value of a typed constant, you should use an untyped constant instead. Typed constants should be replaced with initialized variables to be compatible with future versions of the compiler.</p>
<p>Example:</p>
<pre>
{This adds the constant to the data segment}
const SomeTypedString : string = 'Test';
const SomeTypedInt : integer = 5;
 
{This adds the constant to the code segment if used}
const SomeUnTypedString = 'Test';
const SomeUnTypedInt = 5;
</pre>

