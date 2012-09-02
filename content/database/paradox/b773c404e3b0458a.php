<h1>Как восстановить поврежденную таблицу?</h1>
<div class="date">01.01.2007</div>


<p>How to recover Data in a damaged Header of DbTables.</p>

<p>(Paradox or Dbase) Tables</p>

<p>If this problem occurs and we have not copies of data.</p>

<p>Paradox can't directly open those damaged Tables so</p>
<p>Paradox can't repair those tables.</p>

<p>solution :</p>

<p>T1: the Damaged Table</p>

<p>1- We Have to create an empty Table (T2.Db or</p>
<p>T2.Dbf) that have the same structure of damaged table</p>
<p>(T1.DB or T1.Dbf).</p>

<p>2- With Dos Prompts or excutable batch File we have to</p>
<p>execute this command:</p>

<p>Copy T2.Db+T1.db T3.Db</p>

<p>or</p>

<p>Copy T2.Dbf+T1.dbf T3.Dbf</p>

<p>3-Finally with paradox browser we can open T3 Table</p>
<p>we have to delete bad records.</p>
<p>and copy t3 to t1 table.</p>
<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
