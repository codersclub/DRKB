---
Title: Браузер по реестру
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---

Браузер по реестру
==================

    unit main;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      StdCtrls, Grids, Outline, ComCtrls, ImgList, ExtCtrls;
     
    type
      TRegForm = class(TForm)
        TreeView1: TTreeView;
        ListView1: TListView;
        ImageList1: TImageList;
        ImageList2: TImageList;
        Splitter1: TSplitter;
        procedure FormCreate(Sender: TObject);
        procedure TreeView1Change(Sender: TObject; Node: TTreeNode);
        procedure FormDestroy(Sender: TObject);
        procedure TreeView1Expanded(Sender: TObject; Node: TTreeNode);
        procedure TreeView1GetImageIndex(Sender: TObject; Node: TTreeNode);
      private
        { Private declarations }
      public
        { Public declarations }
        procedure ShowSubKeys(ParentNode: TTreeNode; depth: Integer);
        function GetFullNodeName(Node: TTreeNode): string;
      end;
     
    var
      RegForm: TRegForm;
     
    implementation
    uses registry;
    {$R *.DFM}
    var reg: TRegistry;
     
    function TRegForm.GetFullNodeName(Node: TTreeNode): string;
    var CurNode: TTreeNode;
    begin
      Result := ''; CurNode := Node;
      while CurNode.Parent <> nil do
      begin
        Result := '\' + CurNode.Text + Result;
        CurNode := CurNode.Parent;
      end;
    end;
     
    procedure TRegForm.TreeView1Change(Sender: TObject; Node: TTreeNode);
    var s: string;
      KeyInfo: TRegKeyInfo;
      ValueNames: TStringList;
      i: Integer;
      DataType: TRegDataType;
    begin
      ListView1.Items.Clear;
      s := GetFullNodeName(Node);
      if not Reg.OpenKeyReadOnly(s) then Exit;
      Reg.GetKeyInfo(KeyInfo);
      if KeyInfo.NumValues <= 0 then Exit;
      ValueNames := TStringList.Create;
      Reg.GetValueNames(ValueNames);
      for i := 0 to ValueNames.Count - 1 do
        with ListView1.Items.Add do
        begin
          Caption := ValueNames[i];
          DataType := Reg.GetDataType(ValueNames[i]);
          case DataType of
            rdString: s := Reg.ReadString(ValueNames[i]);
            rdInteger: s := '0x' + IntToHex(Reg.ReadInteger(ValueNames[i]), 8);
            rdBinary: s := 'Binary';
          else s := '???';
          end;
          SubItems.Add(s);
          ImageIndex := 1;
        end;
      ValueNames.Free;
    end;
     
    procedure TRegForm.ShowSubKeys(ParentNode: TTreeNode; depth: Integer);
    var ParentKey: string;
      KeyNames: TStringList;
      KeyInfo: TRegKeyInfo;
      CurNode: TTreeNode;
      i: Integer;
    begin
      Cursor := crHourglass;
      TreeView1.Items.BeginUpdate;
      ParentKey := GetFullNodeName(ParentNode);
      if ParentKey <> '' then
        Reg.OpenKeyReadOnly(ParentKey)
      else
        Reg.OpenKeyReadOnly('\');
      Reg.GetKeyInfo(KeyInfo);
      if KeyInfo.NumSubKeys <= 0 then Exit;
      KeyNames := TStringList.Create;
      Reg.GetKeyNames(KeyNames);
      while ParentNode.GetFirstChild <> nil do ParentNode.GetFirstChild.Delete;
      if (KeyNames.Count > 0) then for i := 0 to KeyNames.Count - 1 do
        begin
          Reg.OpenKeyReadOnly(ParentKey + '\' + KeyNames[i]);
          Reg.GetKeyInfo(KeyInfo);
          CurNode := TreeView1.Items.AddChild(ParentNode, KeyNames[i]);
          if KeyInfo.NumSubKeys > 0 then
          begin
            TreeView1.Items.AddChild(CurNode, ''); //
          end;
        end;
      KeyNames.Free;
      TreeView1.Items.EndUpdate;
      Cursor := crDefault;
    end;
     
    procedure TRegForm.FormCreate(Sender: TObject);
    var root: TTreeNode;
    begin
      Reg := TRegistry.Create;
      ListView1.ViewStyle := vsReport;
      with ListView1 do
      begin
        with Columns.Add do begin Width := ListView1.Width div 3 - 2; Caption := 'Name'; end;
        with Columns.Add do begin Width := ListView1.Width div 3 * 2 - 2; Caption := 'Value'; end;
      end;
      TreeView1.Items.Clear;
      Reg.RootKey := HKEY_LOCAL_MACHINE;
      Root := TreeView1.Items.Add(nil, 'HKEY_LOCAL_MACHINE');
      TreeView1.Items.AddChild(root, '');
    end;
     
    procedure TRegForm.FormDestroy(Sender: TObject);
    begin
      Reg.Free;
    end;
     
    procedure TRegForm.TreeView1Expanded(Sender: TObject; Node: TTreeNode);
    begin
      ShowSubKeys(Node, 1);
    end;
     
    procedure TRegForm.TreeView1GetImageIndex(Sender: TObject; Node: TTreeNode);
    begin
      with Node do
      begin
        if Expanded then ImageIndex := 2
        else ImageIndex := 3;
      end;
    end;
     
    end.


