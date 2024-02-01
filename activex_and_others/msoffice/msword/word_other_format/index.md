---
Title: Как сохранить текст MS Word в другом формате?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как сохранить текст MS Word в другом формате?
=============================================


Создайте новую форму и разместите на ней:

* кнопку Button3,
* компонент RichText с названием WordEditor,
* компонент OpenDialog.

Теперь вы можете выбирать любой файл \*.doc и загружать его в объект RichText.

**Примечание:** `Format:=6` заставит Word сохранять файл как RTF.
Недостаточно указать только расширение файла!

Другие форматы файлов:

* 0 - Обычный (Word format)
* 1 - Шаблон документа
* 2 - Только текст (в кодировке ANSI)
* 3 - Текст с разделителями (текст с переносами строк; кодировка ANSI)
* 4 - Только текст (PC-8) (кодировка IBM PC)
* 5 - Текст с разделителями (PC-8) (текст с переносами строк; кодировка IBM PC)
* 6 - Rich-text format (RTF)

```
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
```

Как сделать, чтобы Word не открывал файлы с паролем или файлы помощника, которые вызывают зависание?

Перед открытием документа нужно добавить:

```
if WordApp.ActiveDocument.HasPassword = True then
  MsgBox("Password Protected");
```

Можно даже задать пароль:

```
WordApp.Password := 'mypassword';
```

**Примечание:**
Если вышеприведённый код выдает "Undefined property: ActiveDocument", то замените:

```
CreateOleObject('Word.Basic');
```

на

```
CreateOleObject('Word.Application');
```
