<h1>Как использовать параметр в Format больше одного раза?</h1>
<div class="date">01.01.2007</div>


<p>Sometimes you probably have written something like this:</p>

<pre>
s := Format('Hello %s, your name is %s %s', [FirstName, FirstName, LastName]);
</pre>

<p>(an admittedly stupid example ;-) )</p>

<p>And if you do, you probably found it annoying that you need to specify the FirstName parameter twice, in particular if there are lots of similar lines. But this isn't necessary because you can specify the parameter position to use for the placeholder</p>
<p>in the format string like this:</p>

<pre>
s := Format('Hello %0:s, your name is %0:s %1:s', [FirstName, LastName]);
</pre>

<p>Just one more example from a code generator I am currently writing:</p>

<pre>
TableName := 'Customer';
...
s := Format(' f%0:sTableAuto := T%0:sTableAuto.Create(f%0:Table);', [TableName]);
</pre>

<p>which results in</p>

<pre>
s := ' fCustomerTableAuto := TCustomerTableAuto.Create(fCustmerTable);';
</pre>


<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
