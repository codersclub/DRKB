<h1>Отладка экспертов</h1>
<div class="date">01.01.2007</div>



<p>Debug Delphi 3 experts with Delphi 3</p>
<p>Delphi 3 has a new feature "debug DLLs". It can be used to debug experts with the internal debugger. Just follow these simple steps, and debugging an expert can be fun:</p>

<p>Make sure that the expert is not installed. If there is this entry</p>
<p>  \CURRENT_USER\software\Delphi\3.0\experts,</p>
<p>  myexpert=\projects\myexpert\expert.dll</p>
<p>rename this entry to "expert.xxx". (don't delete it, you'll need it later).</p>
<p>Otherwise, you cannot compile a new version.</p>

<p>Run Delphi, open your expert's project as used, compile it and set the break points you think you need.</p>

<p>Go to the menu item run | parameters. This is the new Delphi 3 feature mentioned above.</p>

<p>Surprise: the host application is Delphi itself! So, next to the field "host app", enter something like e:\Programs\delphi3\bin\delphi32.exe (with path)</p>

<p>Second trick: now we install the expert... If you have "expert.xxx" installed, rename that to "expert.dll". This will be used by any Delphi instance started from now on.</p>

<p>Run "your application" (= Delphi 3) using menu item run | run.</p>
<p>If you have enough RAM, Delphi is loaded and this instance will have your expert installed.</p>
<p>Activate the expert, you'll have the possibility to use the comfort of the first instance's internal debugger.</p>

<p>Close the right instance of Delphi - and you can modify/ recompile etc. your expert.</p>

<p>Взято с сайта <a href="https://www.delphifaq.com" target="_blank">https://www.delphifaq.com</a></p>
