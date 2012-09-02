<h1>Как получить список папок Outlook?</h1>
<div class="date">01.01.2007</div>


<pre>
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
</pre>
<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
