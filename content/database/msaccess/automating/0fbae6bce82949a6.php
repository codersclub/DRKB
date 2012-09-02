<h1>Opening Access (early binding)</h1>
<div class="date">01.01.2007</div>


<p>Before you can use this method, you must have imported the type library (MSAcc8.olb for Access 97). </p>
<p>One way of starting Access is Excelto try the GetActiveObject call, to get a running instance of Access, but put a call to CoApplication.Create in an except clause. But except clauses are slow, and can cause problems within the IDE for people who like Break On Exceptions set to True. The following code removes the need for a try...except clause, by avoiding using OleCheck on GetActiveObject in the case when Access is not running.</p>
<pre>
  uses Windows, ComObj, ActiveX, Access_TLB;
  var 
    Access: _Application; 
    AppWasRunning: boolean; // tells you if you can close Access when you've finished
    Unknown: IUnknown; 
    Result: HResult; 
  begin 
    AppWasRunning := False;

    {$IFDEF VER120}      // Delphi 4
    Result := GetActiveObject(CLASS_Application_, nil, Unknown); 
    if (Result = MK_E_UNAVAILABLE) then 
      Access := CoApplication_.Create 
 
    {$ELSE}              // Delphi 5
    Result := GetActiveObject(CLASS_AccessApplication, nil, Unknown); 
    if (Result = MK_E_UNAVAILABLE) then 
      Access := CoAccessApplication.Create 
    {$ENDIF}  
          
    else begin 
      { make sure no other error occurred during GetActiveObject } 
      OleCheck(Result); 
      OleCheck(Unknown.QueryInterface(_Application, Access)); 
      AppWasRunning := True; 
    end; 
    Access.Visible := True;
    ...
</pre>
<p>Without using the type library</p>
<p>Automation is so much easier and faster using type libraries (early binding) that you should avoid managing without if at all possible. But if you really can't, here's how to get started:</p>
<pre>
        var 
          Access: Variant; 
        begin 
          try 
            Access := GetActiveOleObject('Access.Application');    
          except 
            Access := CreateOleObject('Access.Application');    
          end; 
          Access.Visible := True; 
 
</pre>

