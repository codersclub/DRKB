---
Title: Отображать элементы TListView как группу XP
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Отображать элементы TListView как группу XP
===========================================

    // declarations from commctrl.h 
    type
      TLVGROUP = record
        cbSize: UINT;
        mask: UINT;
        pszHeader: LPWSTR;
        cchHeader: Integer;
        pszFooter: LPWSTR;
        cchFooter: Integer;
        iGroupIdL: Integer;
        stateMask: UINT;
        state: UINT;
        uAlign: UINT;
      end;
    
      tagLVITEMA = packed record
        mask: UINT;
        iItem: Integer;
        iSubItem: Integer;
        state: UINT;
        stateMask: UINT;
        pszText: PAnsiChar;
        cchTextMax: Integer;
        iImage: Integer;
        lParam: lParam;
        iIndent: Integer;
        iGroupId: Integer;
        cColumns: UINT;
        puColumns: PUINT;
      end;
      TLVITEMA = tagLVITEMA;
    
    const
      LVM_ENABLEGROUPVIEW = LVM_FIRST + 157;
      LVM_MOVEITEMTOGROUP = LVM_FIRST + 154;
      LVM_INSERTGROUP     = LVM_FIRST + 145;
    
      LVIF_GROUPID = $0100;
    
      LVGF_HEADER  = $00000001;
      LVGF_ALIGN   = $00000008;
      LVGF_GROUPID = $00000010;
    
      LVGA_HEADER_LEFT   = $00000001;
      LVGA_HEADER_CENTER = $00000002;
      LVGA_HEADER_RIGHT  = $00000004;
    
    procedure TForm1.Button1Click(Sender: TObject);
    var
      LvGroup: TLVGROUP;
      LvItemA: TLVITEMA;
      ListItem: TListItem;
      I: Byte;
    begin
      // Fill listview with random data 
      Randomize;
      for i := 1 to 10 do
      begin
        ListItem := ListView1.Items.Add;
        ListItem.Caption := IntToStr(Random(100));
      end;
    
      SendMessage(ListView1.Handle, LVM_ENABLEGROUPVIEW, 1, 0);
    
      // Create Group1 
      FillChar(LvGroup, SizeOf(TLVGROUP), 0);
      with LvGroup do
      begin
        cbSize := SizeOf(TLVGROUP);
        mask := LVGF_HEADER or LVGF_ALIGN or LVGF_GROUPID;
        pszHeader := 'Group 1';
        cchHeader := Length(LvGroup.pszHeader);
        iGroupIdL := 0;
        uAlign := LVGA_HEADER_CENTER;
      end;
      SendMessage(ListView1.Handle, LVM_INSERTGROUP, 0, Longint(@LvGroup));
    
      // Create Group2 
      FillChar(LvGroup, SizeOf(LvGroup), 0);
      with LvGroup do
      begin
        cbSize := SizeOf(TLVGROUP);
        mask := LVGF_HEADER or LVGF_ALIGN or LVGF_GROUPID;
        pszHeader := 'Group 2';
        cchHeader := Length(LvGroup.pszHeader);
        iGroupIdL := 1;
        uAlign := LVGA_HEADER_LEFT
      end;
      SendMessage(ListView1.Handle, LVM_INSERTGROUP, 1, Longint(@LvGroup));
    
      // Assign items to the groups 
      for I := 0 to ListView1.Items.Count - 1 do
      begin
        with LvItemA do
        begin
          FillChar(LvItemA, SizeOf(TLvItemA), 0);
          mask := LVIF_GROUPID;
          iItem := I;
          iGroupId := Random(2);
        end;
        SendMessage(ListView1.Handle, LVM_SETITEM, 0, Longint(@LvItemA))
      end;
    end;
    
    // XPManifest needed! 

