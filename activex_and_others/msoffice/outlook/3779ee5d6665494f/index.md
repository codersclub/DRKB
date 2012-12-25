---
Title: Как получить список папок Outlook?
Date: 01.01.2007
---


Как получить список папок Outlook?
==================================

::: {.date}
01.01.2007
:::

    uses 
      ComObj; 
     
    procedure RetrieveOutlookFolders(tvFolders: TTreeView); 
     
      procedure LoadFolder(ParentNode: TTreeNode; Folder: OleVariant); 
      var 
        i: Integer; 
        Node: TTreeNode; 
      begin 
        for i := 1 to Folder.Count do 
        begin 
          Node := tvFolders.Items.AddChild(ParentNode, Folder.Item[i].Name); 
     
          LoadFolder(Node, Folder.Item[i].Folders); 
        end; 
      end; 
    var 
      outlook, NameSpace: OLEVariant; 
    begin 
      outlook   := CreateOleObject('Outlook.Application'); 
      NameSpace := outlook.GetNameSpace('MAPI'); 
     
      LoadFolder(nil, NameSpace.Folders); 
     
      outlook := Unassigned; 
    end; 
     
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      RetrieveOutlookFolders(TreeView1); 
    end; 

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
