<h1>Изменить экранный курсор без необходимости возвращать предыдущий</h1>
<div class="date">01.01.2007</div>


<pre>
// By implementing Interface we can set the cursor without restore it in the end. 
// Example: In convensional way... 
var
   Cur: TCursor;
 begin
   Cur := Screen.Cursor;
   Screen.Cursor := crSQLWait;
   //do coding here 
  //What happend is that if your code did not finish, the screen cursor will 
  //remain as crSQLWait.. even with try..finally block (sometimes) 
  Screen.Cursor := Cur;
 end;
 
 // By using interface, we can implement as follows 
type
   ImyCursor = interface
     [(GUID - Ctrl - Shift - G)]
   end;
   TmyCursor = class(TInterfacedObjects, ImyCursor);
   private
   FCursor: TCursor;
   public
 constructor Create;
   destructor Destroy; override;
     end;
 
 implementation
 
 TmyCursor.Create;
 
 begin
   FCursor := Screen.Cursor;
 end;
 
 TmyCursor.Destroy;
 
 begin
   Screen.Cursor := FCursor;
   inherited;
 end;
 
 procedure....var
   C: ImyCursor;
 begin
   C := TmyCursor.Create;
   Screen.Curosr := crSQLWait; // whatever cursor you like 
  // Do coding here without worring to free it. 
  // Screen Cursor will restore when the TMyCursor object get out of scope. 
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
