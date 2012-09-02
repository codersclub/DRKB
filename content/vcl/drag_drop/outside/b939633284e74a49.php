<h1>Переслать данные в другую программу методом Drag &amp; Drop</h1>
<div class="date">01.01.2007</div>


<pre>
// Autor: Hagen Reddmann
 
         uses
   ShellAPI;
 
 function MakeDrop(const FileNames: array of string): THandle;
 // Creates a hDrop Object 
// erzeugt ein hDrop Object 
var
   I, Size: Integer;
   Data: PDragInfoA;
   P: PChar;
 begin
   // Calculate memory size needed 
  // berechne notwendig Speichergro?e 
  Size := SizeOf(TDragInfoA) + 1;
   for I := 0 to High(FileNames) do
     Inc(Size, Length(FileNames[I]) + 1);
   // allocate the memory 
  // alloziere den speicher 
  Result := GlobalAlloc(GHND or GMEM_SHARE, Size);
   if Result &lt;&gt; 0 then
   begin
     Data := GlobalLock(Result);
     if Data &lt;&gt; nil then
       try
         // fill up with data 
        // fulle daten 
        Data.uSize := SizeOf(TDragInfoA);
         P  := PChar(@Data.grfKeyState) + 4;
         Data.lpFileList := P;
         // filenames at the at of the header (separated with #0) 
        // am ende des headers nun die filenamen getrennt mit #0 
        for I := 0 to High(FileNames) do
         begin
           Size := Length(FileNames[I]);
           Move(Pointer(FileNames[I])^, P^, Size);
           Inc(P, Size + 1);
         end;
       finally
         GlobalUnlock(Result);
       end
     else
     begin
       GlobalFree(Result);
       Result := 0;
     end;
   end;
 end;
 
 function MyEnum(Wnd: hWnd; Res: PInteger): Bool; stdcall;
 // search for a edit control with classname 'TEditControl' 
// suche ein child fenster mit klassennamen 'TEditControl' 
var
   N: string;
 begin
   SetLength(N, MAX_PATH);
   SetLength(N, GetClassName(Wnd, Pointer(N), Length(N)));
   Result := AnsiCompareText('TEditControl', N) &lt;&gt; 0;
   if not Result then Res^ := Wnd;
 end;
 
 // Example: Open msdos.sys in Delphi's Editor window 
// Beispiel: msdos.sys im Delphi Editor offnen 
procedure TForm1.Button1Click(Sender: TObject);
 var
   Wnd: HWnd;
   Drop: hDrop;
 begin
   // search for Delphi's Editor 
  // suche Delphis Editor Fenster 
  EnumChildWindows(FindWindow('TEditWindow', nil), @MyEnum, Integer(@Wnd));
   if IsWindow(Wnd) then
   begin
     // Delphi's Editor found. Open msdos.sys 
    // Delphis editor gefunden, also offne msdos.sys 
    Drop := MakeDrop(['c:\msdos.sys']);
     if Drop &lt;&gt; 0 then PostMessage(Wnd, wm_DropFiles, Drop, 0);
     // Free the memory? 
    // Speicher wieder freigeben? 
    GlobalFree(Drop);
   end;
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
&nbsp;</p>
&nbsp;</p>
