<h1>Using Visual Basic arrays in Delphi</h1>
<div class="date">01.01.2007</div>


<p>How do I pass arrays from VB to Delphi?</p>
<p>Arrays can be passed as variants:</p>
<p>VB module code:</p>
<pre>
Attribute VB_Name = "Module1"
Declare Function TestMin Lib "c:\windows\system\NoelSArr"
   (Nums As Variant) As Integer
</pre>
<p>VB form code:</p>
<pre>
Dim A As Variant
Private Sub Command1_Click()
  A = Array(4, 3)
  MsgBox (TestMin(A))
End Sub
</pre>
<p>Delphi DLL code:</p>
<pre>
library NoelSArray;

function TestMin(const Nums: Variant): integer; export; stdcall;
var
 p1: Variant;
begin
 p1 := VarArrayCreate([0, 1], VT_I4);
 p1:= Nums;
  if (p1[0] &lt; p1[1]) then
   result:= p1[0]
 else
   Result:= p1[1];
end;
</pre>

