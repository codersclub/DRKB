<h1>Microsoft Binder</h1>
<div class="date">01.01.2007</div>


<p>Opening Binder (early binding)</p>
<p>Before you can use this method, you must have imported the type library (MSBdr8.olb for Binder 97).</p>
<p>One way of starting Binder is to try the GetActiveObject call, to get a running instance of Binder, but put a call to CoApplication.Create in an except clause. But except clauses are slow, and can cause problems within the IDE for people who like Break On Exceptions set to True. The following code removes the need for a try...except clause, by avoiding using OleCheck on GetActiveObject in the case when Binder is not running.</p>
<pre class="delphi">uses Windows, ComObj, ActiveX, OfficeBinder_TLB;
var 
  Binder: _Binder;
  AppWasRunning: boolean; // tells you if you can close Binder when you've finished
  Unknown: IUnknown; 
  Result: HResult; 
begin 
  AppWasRunning := False;
  Result := GetActiveObject(CLASS_Binder, nil, Unknown);
  if (Result = MK_E_UNAVAILABLE) then
    Binder := CoBinder.Create
  else begin
    { make sure no other error occurred during GetActiveObject }
    OleCheck(Result);
    OleCheck(Unknown.QueryInterface(_Binder, Binder));
    AppWasRunning := True;
  end;
  Binder.Visible := True;
  ...
</pre>

<p>Without using the type library</p>
<p>Automation is so much easier and faster using type libraries (early binding) that you should avoid managing without if at all possible. But if you really can't, here's how to get started:</p>
<pre class="delphi">
var 
  Binder: Variant; 
begin 
  try 
    Binder := GetActiveOleObject('Office.Binder');    
  except 
    Binder := CreateOleObject('Office.Binder');    
  end; 
  Binder.Visible := True; 
</pre>
</p>
</p>

<p>&gt;&gt;&gt;&gt;&gt;How to close Binder&lt;&lt;&lt;&lt;&lt;</p>
<p>Here's the quick version:</p>
<pre class="delphi">
Binder.Close(False, ''); 
</pre>
</p>
<p>The first parameter determines whether changes to the open binder will be saved before closing. If you use EmptyParam for this parameter, the user will be asked whether to save if appropriate.</p>
<p>The second parameter is for the name the binder should be given when it is saved, if it hasn't already been given a name. If the binder has already been saved, this parameter is ignored.</p>

