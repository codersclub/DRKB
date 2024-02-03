---
Title: Как сохранить текст MS Word в другом формате?
Date: 01.01.2007
---


Как сохранить текст MS Word в другом формате?
=============================================

::: {.date}
01.01.2007
:::

Open a new Application and place:

a button named Button3,

a RitchText object named WordEditor

and an OpenDialog component.

From now on, you can browse for any *.doc file and load it into the
RitchText object.

NOTE: Format:=6 instructs Word to save the file as RTF. Extension is not
enough.

Other File Formats:

Argument Format          File Format       0        Normal (Word format)
      1        Document Template       2        Text Only (extended
characters saved in ANSI character set)       3        Text+Breaks
(plain text with line breaks; extended characters saved in ANSI
character set)       4        Text Only (PC-8) (extended characters
saved in IBM PC character set)       5        Text+Breaks (PC-8) (text
with line breaks; extended characters saved in IBM PC character set)    
  6        Rich-text format (RTF)      

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

How to prevent word from opening password-protected files or resume
wizard files and sometimes causing application to hang ?

The sollution is to add the folowing query before openning the document:

if WordApp.ActiveDocument.HasPassword = True then

MsgBox("Password Protected");

You can even preset the password propery as:

WordApp.Password := \'mypassword";

NOTE: If the above code generates an "Undefined property:
ActiveDocument" change the:

CreateOleObject(\'Word.Basic\');

with

CreateOleObject(\'Word.Application\');

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
