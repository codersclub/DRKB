<h1>Как поставить свой формат в TDateTimePicker?</h1>
<div class="date">01.01.2007</div>


<pre>
uses CommCtrl;
 
  const fmt: PChar = 'hh:mm';
 
  SendMessage(DateTimePicker1.Handle, DTM_SETFORMAT, 0, LongInt(fmt));
</pre>

