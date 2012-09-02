<h1>Как инициализировать BDE, если она установлена в нестандартном месте?</h1>
<div class="date">01.01.2007</div>



<p>I need to use a BDE that is placed in another directory than default. How can I do it? DbiInit(pDbiEnv) doesn't work when pDbiEnv &lt; &gt; nil (not default).</p>

<p>Answer:</p>
<pre>
pDbiEnv := nil;
check(DbiInit(pDbiEnv));
</pre>


<p>or if you don't need the pointer simply</p>

<p>check(DbiInit(nil));</p>
<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
