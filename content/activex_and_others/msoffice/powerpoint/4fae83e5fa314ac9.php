<h1>Opening PowerPoint</h1>
<div class="date">01.01.2007</div>

<p>Opening PowerPoint (early binding)</p>
<p>Before you can use this method, you must have imported the type library (MSPpt8.olb for PowerPoint 97).</p>
<p>One way of starting PowerPoint is to try the GetActiveObject call, to get a running instance of PowerPoint, but put a call to CoApplication.Create in an except clause. But except clauses are slow, and can cause problems within the IDE for people who like Break On Exceptions set to True. The following code removes the need for a try...except clause, by avoiding using OleCheck on GetActiveObject in the case when PowerPoint is not running.</p>
<pre>
uses Windows, ComObj, ActiveX, OfficePowerPoint_TLB;
 
var 
  PowerPoint: _Application;
  AppWasRunning: boolean; // tells you if you can close PowerPoint when you've finished
  Unknown: IUnknown; 
  Result: HResult; 
begin 
  AppWasRunning := False;
  Result := GetActiveObject(CLASS_Application, nil, Unknown);
  if (Result = MK_E_UNAVAILABLE) then
    PowerPoint := CoApplication.Create
  else begin
    { make sure no other error occurred during GetActiveObject }
    OleCheck(Result);
    OleCheck(Unknown.QueryInterface(_Application, PowerPoint));
    AppWasRunning := True;
  end;
  PowerPoint.Visible := TOleEnum(msoTrue);
  ...
</pre>
&nbsp;</p>

<p>Without using the type library</p>
<p>Automation is so much easier and faster using type libraries (early binding) that you should avoid managing without if at all possible. But if you really can't, here's how to get started:</p>
<pre>
var 
  PowerPoint: Variant; 
begin 
  try 
    PowerPoint := GetActiveOleObject('PowerPoint.Application');    
  except 
    PowerPoint := CreateOleObject('PowerPoint.Application');    
  end; 
  PowerPoint.Visible := True; 
</pre>

