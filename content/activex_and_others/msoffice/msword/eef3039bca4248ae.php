<h1>Как сохранить текст MS Word в другом формате?</h1>
<div class="date">01.01.2007</div>



<p>Open a new Application and place:</p>

<p>  a button named Button3,</p>
<p>  a RitchText object named WordEditor</p>
<p>  and an OpenDialog component.</p>

<p>From now on, you can browse for any *.doc file and load it into the RitchText object.</p>

<p>NOTE: Format:=6 instructs Word to save the file as RTF. Extension is not enough.</p>

<p>Other File Formats:</p>

Argument Format&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;File Format  &nbsp; &nbsp; &nbsp; 
0 &nbsp; &nbsp; &nbsp; &nbsp;Normal (Word format)  &nbsp; &nbsp; &nbsp; 
1 &nbsp; &nbsp; &nbsp; &nbsp;Document Template  &nbsp; &nbsp; &nbsp; 
2 &nbsp; &nbsp; &nbsp; &nbsp;Text Only (extended characters saved in ANSI character set)  &nbsp; &nbsp; &nbsp; 
3 &nbsp; &nbsp; &nbsp; &nbsp;Text+Breaks (plain text with line breaks; extended characters saved in ANSI character set)  &nbsp; &nbsp; &nbsp; 
4 &nbsp; &nbsp; &nbsp; &nbsp;Text Only (PC-8) (extended characters saved in IBM PC character set)  &nbsp; &nbsp; &nbsp; 
5 &nbsp; &nbsp; &nbsp; &nbsp;Text+Breaks (PC-8) (text with line breaks; extended characters saved in IBM PC character set)  &nbsp; &nbsp; &nbsp; 
6 &nbsp; &nbsp; &nbsp; &nbsp;Rich-text format (RTF)  &nbsp; &nbsp; &nbsp; 
<pre>
procedure TImport_Form.ToolButton3Click(Sender: TObject);
var
  WordApp: Variant;
begin
  if OpenDialog1.Execute then
  begin
    Edit1.Text := ExtractFileName(OpenDialog1.FileName);
    StatusBar1.SimpleText := OpenDialog1.FileName;
    WordApp := CreateOleObject('Word.Basic');
    if not VarIsEmpty(WordApp) then
    begin
      WordApp.FileOpen(OpenDialog1.FileName);
      WordApp.FileSaveAs(Name := 'c:\temp_bb.rtf', Format := 6);
      WordApp.AppClose;
      WordApp := Unassigned;
      WordEditor.Lines.LoadFromFile('c:\temp_bb.rtf');
    end
    else
      ShowMessage('Could not start MS Word');
  end;
 
end;
</pre>


<p>How to prevent word from opening password-protected files or resume wizard files and sometimes causing application to hang ?</p>

<p>The sollution is to add the folowing query before openning the document:</p>

<p>if WordApp.ActiveDocument.HasPassword = True then</p>
<p>  MsgBox("Password Protected");</p>

<p>You can even preset the password propery as:</p>

<p>WordApp.Password := 'mypassword";</p>

<p>NOTE: If the above code generates an "Undefined property: ActiveDocument" change the:</p>

<p>CreateOleObject('Word.Basic');</p>

<p>with</p>

<p>CreateOleObject('Word.Application');</p>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>

