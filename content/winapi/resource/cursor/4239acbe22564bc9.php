<h1>Как запретить показ курсора в TEdit и ему подобных контролах?</h1>
<div class="date">01.01.2007</div>


<p>Создайте своего потомка с обработчиками:</p>
<p>procedure WMPaint(var Msg: TMessage); message WM_Paint;</p>
<p>procedure WMSetFocus(var Msg: TMessage); message WM_SetFocus;</p>
<p>procedure WMNCHitTest(var Msg: TMessage); message WM_NCHitTest;</p>
<p>в которых вызывайте:</p>
<p>inherited;</p>
<p>HideCaret(Handle);</p>

