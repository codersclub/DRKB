<h1>Как добавить в диалог TOpenDialog свой CheckBox?</h1>
<div class="date">01.01.2007</div>


<p>Вообще, винда предоставляет возможность расширения некоторых стандартных диалогов с помощью шаблонов и hook-процедуры. Например, для OpenFileDialog'а пишется к примеру, такой rc-скрипт с шаблоном<br>
 <br>
<p>myres.rc</p>
<pre>
OFT DIALOG -1, 1, 304, 62
STYLE DS_3DLOOK | DS_CONTROL | WS_CHILD | WS_VISIBLE | WS_CLIPSIBLINGS
CAPTION ""
FONT 8, "MS Sans Serif"
{
 CONTROL "Select Options", 100, "button", BS_GROUPBOX | WS_CHILD | WS_VISIBLE | WS_GROUP, 69, 4, 224, 52
 CONTROL "CheckBox1", 101, "button", BS_AUTOCHECKBOX | WS_CHILD | WS_VISIBLE | WS_TABSTOP, 84, 19, 60, 12
 CONTROL "CheckBox2", 102, "button", BS_AUTOCHECKBOX | WS_CHILD | WS_VISIBLE | WS_TABSTOP, 84, 38, 60, 12
}
</pre>
<br>
потом он компилится <br>
<p></p>
<p>brcc32.exe myres.rc</p>
<p> <br>
 <br>
 <br>
и получается myres.res, который линкуется к проекту директивой {$R} (удобнее, конечно создавать и компилить шаблон в каком-нить редакторе ресурсов, типа Resource Workshop'а).<br>
 <br>
Ну а в проге заполняется структура TOpenFileName (надо в uses подключить commdlg), у которой в поле lpTemplateName задается имя шаблона, а в поле lpfnHook - hook-процедура. В этой hook-процедуре и обрабатывается реакция на дополнительные контролы (например чекбоксы). Там же можно обработать смену типа файла, директории, выбранного файла, нажатие на OK, etc. <br>
Ну а для показа самого диалога вызывается API'шная GetOpenFileName <br>
 <br>
Короче, вот пример кода<br>
<p></p>
<pre>
uses
 commdlg;

 
{$R *.dfm}
 
{$R MYRES.RES} // файл ресурсов с шаблоном
 
var
  ofn:TOpenFileName;
  f:array[0..MAX_PATH-1] of Char;
 
// hook-процедура
function Fh(Wnd: HWND; Msg:cardinal; wParam,lParam: Integer): UINT stdcall;
begin
result:=0;
case Msg of
  WM_INITDIALOG:
             begin
              CheckDlgButton(Wnd,101,BST_CHECKED);  // отметим первый чекбокс
             end;
  WM_COMMAND: // реакция на изменение состояния чекбоксов
      case LOWORD(wParam) of
       101:
          begin
           if (IsDlgButtonChecked(Wnd,101)=BST_CHECKED) then MessageBox(Wnd,'CheckBox1 Checked!','FileOpenDialog',0);
          end;
       102:
          begin
           if (IsDlgButtonChecked(Wnd,102)=BST_CHECKED) then MessageBox(Wnd,'CheckBox2 Checked!','FileOpenDialog',0);
          end;
 
      end;
WM_NOTIFY:
   case
   POFNotify(lParam)^.hdr.code of
    CDN_FILEOK:  // реакция на выбор файла
        begin
         if (IsDlgButtonChecked(Wnd,101)=BST_CHECKED) then
          MessageBox(Wnd,PChar('CheckBox1 Checked and '+ofn.lpstrFile+' selected'),'FileOpenDialog',0);
 
         if (IsDlgButtonChecked(Wnd,102)=BST_CHECKED) then
          MessageBox(Wnd,PChar('CheckBox2 Checked and '+ofn.lpstrFile+' selected'),'FileOpenDialog',0);
 
         end;
   end;
end;
end;
 
 
 
procedure TForm1.Button1Click(Sender: TObject);
begin
 FillChar(f,sizeof(f),0);
 FillChar(ofn,sizeof(ofn),0);
 
 ofn.lStructSize := sizeof(TOpenFileName);
 ofn.hwndOwner := Handle;
 ofn.hInstance := hInstance;
 
 ofn.lpstrFilter       :=  'Text Files (*.TXT)'#0'*.txt'#0+
                            'Executables (*.EXE)'#0'*.exe'#0+
                            'All files (*.*)'#0'*.*'#0#0;
 ofn.lpstrTitle        := 'Select File';
 ofn.lpstrFile         := f;
 ofn.nMaxFile          := MAX_PATH;
 ofn.lpTemplateName    :='OFT';   // имя шаблона
 ofn.lpfnHook          := Fh;     // hook-процедура
 ofn.Flags             := OFN_EXPLORER or OFN_CREATEPROMPT or
                          OFN_FILEMUSTEXIST or OFN_HIDEREADONLY or
                          OFN_PATHMUSTEXIST or OFN_ENABLEHOOK or
                          OFN_ENABLETEMPLATE;
 // показываем диалог
 if GetOpenFileName(ofn) then ShowMessage(ofn.lpstrFile);
end;
 
</pre>
 <br>
<div class="author">Автор: Krid</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a><br>
<p></p>
