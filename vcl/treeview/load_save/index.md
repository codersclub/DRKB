---
Title: Сохранить и загрузить TTreeView
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Сохранить и загрузить TTreeView
===============================

    { 
      Treeview1.SaveToFile('...') doesn't store images. 
      Instead, use the code below. 
    }
     
     
    // Save 
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      F: TFileStream;
    begin
      F := TFileStream.Create('c:\TreeView.txt', fmCreate or fmShareCompat);
      try
        F.WriteComponent(TreeView1);
      finally
        F.Free;
      end;
    end;
    
    
    // Load 
     
    procedure TForm1.Button2Click(Sender: TObject);
    var
      F: TFileStream;
    begin
      F := TFileStream.Create('c:\TreeView.txt', fmOpenRead or fmShareDenyWrite);
      try
        F.ReadComponent(TreeView1);
      finally
        F.Free;
      end;
    end;

