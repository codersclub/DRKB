---
Title: Скопировать строки TListBox в буфер обмена
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Скопировать строки TListBox в буфер обмена
==========================================

    uses
      Clipbrd;
     
    procedure ListBoxToClipboard(ListBox: TListBox;
      BufferSize: Integer;
      CopyAll: Boolean);
    var
      Buffer: PChar;
      Size: Integer;
      Ptr: PChar;
      I: Integer;
      Line: string[255];
      Count: Integer;
    begin
      if not Assigned(ListBox) then
        Exit;
    
      GetMem(Buffer, BufferSize);
      Ptr   := Buffer;
      Count := 0;
      for I := 0 to ListBox.Items.Count - 1 do
      begin
        Line := ListBox.Items.strings[I];
        if not CopyAll and ListBox.MultiSelect and (not ListBox.Selected[I]) then
          Continue;
        { Check buffer overflow }
        Count := Count + Length(Line) + 3;
        if Count = BufferSize then
          Break;
        { Append to buffer }
        Move(Line[1], Ptr^, Length(Line));
        Ptr    := Ptr + Length(Line);
        Ptr[0] := #13;
        Ptr[1] := #10;
        Ptr    := Ptr + 2;
      end;
      Ptr[0] := #0;
      ClipBoard.SetTextBuf(Buffer);
      FreeMem(Buffer, BufferSize);
    end;
    
    procedure ClipboardToListBox(ListBox: TListbox);
    begin
      if not Assigned(ListBox) then
        Exit;
    
      if not Clipboard.HasFormat(CF_TEXT) then
        Exit;
    
      Listbox.Items.Text := Clipboard.AsText;
    end;
    
    
    //Copy all items from Listbox1 to the clipboard 
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      ListBoxToClipboard(ListBox1, 1024, True);
    end;
    
    //Paste items in clipboard to Listbox2 
    procedure TForm1.Button2Click(Sender: TObject);
    begin
      ClipboardToListBox(Listbox2);
    end;
    
    //Copy only selected items from Listbox1 to the clipboard 
    procedure TForm1.Button3Click(Sender: TObject);
    begin
      ListBoxToClipboard(Listbox1, 1024, False);
    end;

