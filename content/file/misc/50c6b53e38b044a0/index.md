---
Title: Пример написания FileListBox
Author: Mikel
Date: 01.01.2007
---


Пример написания FileListBox
============================

::: {.date}
01.01.2007
:::

1)WinAPI

    {uses ShellApi}
    procedure TForm1.ListBox1DblClick(Sender: TObject);
    var s:string;
    begin
    s:=listbox1.Items[SendMessage(ListBox1.Handle,lb_GetCurSel,0,0)];
    if edit1.Text[length(edit1.text)]<>'\' then edit1.text:=concat(edit1.text+'\');
    if (not FileExists(edit1.text+s)) and (s[1]='[')and(s[length(s)]=']') then
    DlgDirList( handle,
    PChar(edit1.text+copy(s,2,length(s)-2)),
    ListBox1.Handle,
    Edit1.Handle,
    faAnyFile
     );
    if edit1.Text[length(edit1.text)]<>'\' then edit1.text:=concat(edit1.text+'\');
    if FileExists(edit1.text+s) then
    begin
    caption:=edit1.text+s;
    ShellExecute(handle,'open',PChar(edit1.text+s),'','c:\',sw_show);
    end
    end;
    procedure TForm1.FormShow(Sender: TObject);
    begin
    edit1.Width:=1024*8-1;
    edit1.Visible:=false;
    DlgDirList(handle,
    PChar('c:\'),
    ListBox1.Handle,
    Edit1.Handle,
    faAnyFile
    );
    listbox1.Sorted:=false;
    listbox1.Sorted:=true;
    end;

2)

    {uses ShellAPI}
    type PListBox=^TListBox;
    Procedure FillList(List:PListBox;pathh,mask:string;attr:Cardinal);
    var path:string;
    ser:TSearchRec;
    begin
    path:=pathh;
    if path[length(path)]<>'\' then path:=path+'\';
    List^.Items.Clear;
    if FindFirst(path+mask,attr,ser)<>0 then exit;
    List^.Items.Add(ser.Name);
    while FindNext(ser)=0 do
    begin
    if ser.Attr and faDirectory=faDirectory then 
    List^.Items.Add(' ['+Ser.Name+']')
    else 
    List^.Items.Add(Ser.Name);
    end;
    List^.Sorted:=false;
    list^.Sorted:=true;
    end;
    procedure TForm1.FormCreate(Sender: TObject);
    begin
    FillList(@ListBox1,edit1.text,'*.*',faAnyFile);
    end;
    procedure TForm1.ListBox1DblClick(Sender: TObject);
    var s:string;
    begin
    s:=ListBox1.Items[SendMessage(ListBox1.Handle,lb_GetCurSel,0,0)];
    if (not FileExists(edit1.text+s)) and (s[1]+s[2]=' [') and (s[length(s)]=']') then
    begin
    FillList(@ListBox1,edit1.text+copy(s,3,length(s)-3),'*.*',faAnyFile);
    edit1.text:=edit1.text+copy(s,3,length(s)-3)+'\';
    end;
    if FileExists(edit1.text+s) then 
    ShellExecute(handle,'open',PChar(edit1.text+s),'','c:\',sw_show);
    end;
     

Добавим иконки:

    {uses ShellAPI}
    type PListBox=^TListBox;
     
    Procedure FillList(List:PListBox;pathh,mask:string;attr:Cardinal);
    var path:string;
    ser:TSearchRec;
    begin
    path:=pathh;
    if path[length(path)]<>'\' then path:=path+'\';
    List^.Items.Clear;
    if FindFirst(path+mask,attr,ser)<>0 then exit;
    List^.Items.Add(ser.Name);
    while FindNext(ser)=0 do
    begin
    if ser.Attr and faDirectory=faDirectory then 
      List^.Items.Add(' ['+Ser.Name+']')
    else 
      List^.Items.Add(Ser.Name);
    end;
    List^.Sorted:=false;
    list^.Sorted:=true;
    end;
     
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      FillList(@ListBox1,edit1.text,'*.*',faAnyFile);
      listbox1.itemheight:=18;
    end;
     
    procedure TForm1.ListBox1DblClick(Sender: TObject);
    var s:string;
      Icon:hIcon;
      IconIndex:word;
    begin
    IconIndex:=1;
    s:=ListBox1.Items[SendMessage(ListBox1.Handle,lb_GetCurSel,0,0)];
    if (not FileExists(edit1.text+s)) and (s[1]+s[2]=' [') and (s[length(s)]=']') then
    begin
      FillList(@ListBox1,edit1.text+copy(s,3,length(s)-3),'*.*',faAnyFile);
      edit1.text:=edit1.text+copy(s,3,length(s)-3)+'\';
    end;
    if FileExists(edit1.text+s) then 
    ShellExecute(handle,'open',PChar(edit1.text+s),'','c:\',sw_show);
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var a:array of integer;
    i:integer;
    begin
    SetLength(a,ListBox1.Items.Count+1);
    //ZeroMemory(@a,ListBox1.Items.Count*4);
    for i:=0 to ListBox1.Items.Count+1 do
    a[i]:=10;
    beep;
    beep;
    beep;
    beep;
    beep;
    SendMessage(ListBox1.Handle,lb_SetTabStops,ListBox1.Items.Count,Integer(@a));
    end;
     
    procedure TForm1.ListBox1DrawItem(Control: TWinControl; Index: Integer;
    Rect: TRect; State: TOwnerDrawState);
    var icon:hIcon;
    iconindex:word;
    bm:TBitmap;
    begin
    iconindex:=1;
    bm:=TBitmap.create;
    bm.Width:=34;
    bm.Height:=34;
    ListBox1.Canvas.TextOut(17+Rect.Left,Rect.Top,ListBox1.Items[index]);
    if (copy(ListBox1.Items[index],1,2)=' [') and 
       (not FileExists(edit1.text+ListBox1.Items[Index])) then
    begin
    Icon := ExtractAssociatedIcon(HInstance,
    PChar(edit1.text+copy(ListBox1.Items[Index],3,length(ListBox1.Items[Index])-3)),
    IconIndex);
    DrawIcon(bm.Canvas.Handle, 0, 0, Icon);
    bm.Canvas.StretchDraw(classes.rect(0,0,16,16),bm);
    ListBox1.Canvas.CopyRect(classes.rect(0,rect.top,16,rect.top+16),bm.canvas,classes.rect(0,0,16,16));
    end
    else
    begin
    Icon := ExtractAssociatedIcon(HInstance,
    PChar(edit1.text+ListBox1.Items[Index]),
    IconIndex);
    DrawIcon(bm.Canvas.Handle, 0, 0, Icon);
    bm.Canvas.StretchDraw(classes.rect(0,0,16,16),bm);
    ListBox1.Canvas.CopyRect(classes.rect(0,rect.top,16,rect.top+16),bm.canvas,classes.rect(0,0,16,16));
    end;
    bm.Free;
    CloseHandle(Icon);
    end;
     
    procedure TForm1.ListBox1KeyDown(Sender: TObject; var Key: Word;
    Shift: TShiftState);
    begin
      ListBox1.Repaint;
    end;
     
    procedure TForm1.ListBox1MouseDown(Sender: TObject; Button: TMouseButton;
    Shift: TShiftState; X, Y: Integer);
    var k:word;
    begin
      k:=0;
      Listbox1.OnKeyDown(sender,k,shift);
    end;

Автор: Mikel

Взято с Vingrad.ru <https://forum.vingrad.ru>
