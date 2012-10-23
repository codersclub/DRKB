<h1>Прерывание работы принтера</h1>
<div class="date">01.01.2007</div>


<p>При вызове Printer.Abort должен вызываться код</p>

<p> &nbsp;&nbsp; WinProcs.AbortProc(Printer.Handle)</p>

<p>но этого не происходит. Вызывайте это сами каждый раз при использовании Printer.Abort.</p>
<p>Взято из Советов по Delphi от <a href="mailto:mailto:webmaster@webinspector.com" target="_blank">Валентина Озерова</a></p>
<p>Сборник Kuliba</p>

