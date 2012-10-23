<h1>Как восстановить целостность автоинкрементного поля?</h1>
<div class="date">01.01.2007</div>



<p>Problem/Question/Abstract:</p>

<p>Recently I got unique key violations during insert attempts on a piece of code that used to work (what can go bad, will go bad). I found that the offending field - was actually created by a generator. For some reason the generator returned values that where already in the database.</p>

<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>how can I display the current value of the generator?</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>how can I adjust the value of the generator?</td></tr></table>
<p>Answer:</p>

<p>See the example (table name is SD_LOAD, generator name is GEN_SD_LOAD).</p>

<p>Note:</p>

<p>You cannot modify the value of the generator inside of a trigger or stored procedure. You only can call the gen_id() function to increment the value in a generator. The SET GENERATOR command will only work outside of a stored procedure or trigger.</p>

<p>SELECT DISTINCT(GEN_ID(gen_sd_load, 0))FROM sd_load</p>

<p>set GENERATOR gen_sd_load to 2021819</p>
<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
