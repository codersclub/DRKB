<h1>Дерево каталогов</h1>
<div class="date">01.01.2007</div>


<p>Сегодня поговорим о том, как при помощи TreeView сделать дерево каталогов, то есть нечто, вроде левой части Проводника. Самый простой способ - это при запуске программы найти все каталоги на диске и засунуть их в TreeView. Но у этого способа есть несколько недостатков. Во-первых, он долгий, особенно, если включен zif. Во-вторых, даже если закрыть и открыть какую-то папку, она не обновится. Поэтому лучше всего вначале сделать в TreeView список дисков со значком "+", то есть указать, что на диске есть каталоги. Это не всегда верно, но проверять, правда ли это, долго из-за дисковода. При попытке раскрыть каталог или диск программа ищет подкаталоги и добавляет их в ListView. В каждом подкаталоге программа пытается найти хотя бы один подкаталог. В зависимости от результатов поиска "+" появляется или нет. </p>
<p>В этой программе используются иконки из файла FileCtrl.res, находящемся в каталоге "Delphi5\lib". </p>
<p>implementation</p>
<pre>{$R *.DFM}
{$R FileCtrl}
 
procedure NextLevel(ParentNode: TTreeNode);
  function DirectoryName(name: string): boolean;
  begin
    result := (name &lt;&gt; '.') and (name &lt;&gt; '..');
  end;
var
  sr, srChild: TSearchRec;
  node: TTreeNode;
  path: string;
begin
  node := ParentNode;
  path := '';
  repeat
    path := node.Text + '\' + path;
    node := node.Parent;
  until node = nil;
  if FindFirst(path + '*.*', faDirectory, sr) = 0 then begin
    repeat
      if (sr.Attr and faDirectory &lt;&gt; 0) and DirectoryName(sr.Name) then begin
        node := Form1.TreeView1.Items.AddChild(ParentNode, sr.Name);
        node.ImageIndex := 0;
        node.SelectedIndex := 1;
        node.HasChildren := false;
        if FindFirst(path + sr.Name + '\*.*', faDirectory, srChild) = 0 then begin
          repeat
            if (srChild.Attr and faDirectory &lt;&gt; 0) and DirectoryName(srChild.Name)
              then node.HasChildren := true;
          until (FindNext(srChild) &lt;&gt; 0) or node.HasChildren;
        end;
        FindClose(srChild);
      end;
    until FindNext(sr) &lt;&gt; 0;
  end else ParentNode.HasChildren := false;
  FindClose(sr);
end;
 
procedure TForm1.FormCreate(Sender: TObject);
const
  IconNames: array [0..6] of string = ('CLOSEDFOLDER', 'OPENFOLDER',
    'FLOPPY', 'HARD', 'NETWORK', 'CDROM', 'RAM');
var
  c: char;
  s: string;
  node: TTreeNode;
  DriveType: integer;
  bm, mask: TBitmap;
  i: integer;
begin
  TreeView1.Items.BeginUpdate;
  TreeView1.Images := TImageList.CreateSize(16, 16);
  bm := TBitmap.Create;
  mask := TBitmap.Create;
  for i := low(IconNames) to high(IconNames) do begin
    bm.Handle := LoadBitmap(HInstance, PChar(IconNames[i]));
    bm.Width := 16;
    bm.Height := 16;
    mask.Assign(bm);
    mask.Mask(clBlue);
    TreeView1.Images.Add(bm, mask);
  end;
  for c := 'A' to 'Z' do begin
    s := c + ':';
    DriveType := GetDriveType(PChar(s));
    if DriveType = 1 then continue;
    node := Form1.TreeView1.Items.AddChild(nil, s);
    case DriveType of
      DRIVE_REMOVABLE: node.ImageIndex := 2;
      DRIVE_FIXED: node.ImageIndex := 3;
      DRIVE_REMOTE: node.ImageIndex := 4;
      DRIVE_CDROM: node.ImageIndex := 5;
      else node.ImageIndex := 6;
    end;
    node.SelectedIndex := node.ImageIndex;
    node.HasChildren := true;
  end;
  TreeView1.Items.EndUpdate;
end;
 
procedure TForm1.TreeView1Expanding(Sender: TObject; Node: TTreeNode;
  var AllowExpansion: Boolean);
begin
  TreeView1.Items.BeginUpdate;
  node.DeleteChildren;
  NextLevel(node);
  TreeView1.Items.EndUpdate;
end;
</pre>

