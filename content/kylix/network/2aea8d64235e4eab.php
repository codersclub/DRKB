<h1>Using a DSO on Apache 2.0.43, created with Kylix 3</h1>
<div class="date">01.01.2007</div>


<p>After compiling and installing Apache 2.0.39 with DSO support, deploying an .so file built with Kylix 3 doesn't work.</p>
<p>You need to change MODULE_MAGIC_NUMBER_MAJOR in HTTPD.pas file to the following: MODULE_MAGIC_NUMBER_MAJOR = 20020903;</p>
