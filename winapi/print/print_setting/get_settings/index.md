---
Title: Как прочитать список возможностей принтера?
Date: 12.12.1999
Author: A. Weidauer, alex.weiauer@huckfinn.de 
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---

Как прочитать список возможностей принтера?
===========================================

    uses 
      Printers; 
     
    //------------------------------------------------------------------------------ 
    // Printer Device Debugging Code to TMemo Componenet 
    // (c) - 1999 / by A. Weidauer 
    // alex.weiauer@huckfinn.de 
    //------------------------------------------------------------------------------ 
     
    procedure GetDeviceSettings(DevCtrl: TMemo); 
    var 
      Sep: string; 
      //----------------------------------------------- 
      procedure MakeInt(S: string; key: Integer); 
      begin 
        S := UpperCase(S); 
        DevCtrl.Lines.Add(UpperCase(Format(' %36S = %d ', 
          [s, GetDeviceCaps(Printer.Handle, Key)]))); 
      end; 
      //----------------------------------------------- 
      function StringToBits(S: string): string; 
      var 
        H: string; 
        i: Integer; 
        //----------------------------------------------- 
        function SubStr(C: Char): string; 
        begin 
          if c = '0' then SubStr := '0000'; 
          if c = '1' then SubStr := '0001'; 
          if c = '2' then SubStr := '0010'; 
          if c = '3' then SubStr := '0011'; 
          if c = '4' then SubStr := '0100'; 
          if c = '5' then SubStr := '0101'; 
          if c = '6' then SubStr := '0110'; 
          if c = '7' then SubStr := '0111'; 
          if c = '8' then SubStr := '1000'; 
          if c = '9' then SubStr := '1001'; 
          if c = 'A' then SubStr := '1010'; 
          if c = 'B' then SubStr := '1011'; 
          if c = 'C' then SubStr := '1100'; 
          if c = 'D' then SubStr := '1101'; 
          if c = 'E' then SubStr := '1110'; 
          if c = 'F' then SubStr := '1111'; 
        end; 
        //----------------------------------------------- 
      begin 
        StringToBits := ''; 
        S := UpperCase(s); 
        H := ''; 
        if Length(S) = 0 then Exit; 
        if Length(S) = 1 then S := '0000' + S; 
        if Length(S) = 2 then S := '000' + S; 
        if Length(S) = 3 then S := '00' + S; 
        if Length(S) = 4 then S := '0' + S; 
        for i := 1 to Length(s) do 
          H := H + ' ' + SubStr(S[i]); 
        StringToBits := H; 
      end; 
      //----------------------------------------------- 
      procedure MakeHex(S: string; key: Cardinal); 
      var 
        h: string; 
      begin 
        S := UpperCase(S); 
        h := Format('%X', [GetDeviceCaps(Printer.Handle, Key)]); 
        if Length(H) = 0 then Exit; 
        if Length(H) = 1 then H := '0000' + H; 
        if Length(H) = 2 then H := '000' + H; 
        if Length(H) = 3 then H := '00' + H; 
        if Length(H) = 4 then H := '0' + H; 
        DevCtrl.Lines.Add(''); 
        DevCtrl.Lines.Add(SEP); 
        DevCtrl.Lines.Add(''); 
        DevCtrl.Lines.Add(Format('%37S = Flags(%S) Key(%S)', 
          [s, h, StringToBits(H)] 
          )); 
        // (( GetDeviceCaps(Printer.Handle,Key), 
      end; 
      //---------------------------------------------------- 
      procedure MakeFlag(S: string; key, subKey: Cardinal); 
      var 
        i: Cardinal; 
      begin 
        S := UpperCase(S); 
        i := GetDeviceCaps(Printer.Handle, Key); 
        if i and SubKey <> 0 then 
          DevCtrl.Lines.Add(Format(' %34S = Flag(%4S) Key(%6D,%S)', 
            [s, 'ON ', SubKey, StringToBits(Format('%x', [SubKey]))])) 
        else 
          DevCtrl.Lines.Add(Format(' %34S = Flag(%4S) Key(%6D,%S)', 
            [s, 'OFF', SubKey, StringToBits(Format('%x', [SubKey]))])) 
      end; 
      //---------------------------------------------------- 
      function TechnoToStr(i: Integer): string; 
      begin 
        TechnoToStr := '#ERROR# is Unknwon'; 
        case i of 
          DT_PLOTTER: TechnoToStr    := 'Vector Plotter'; 
          DT_RASDISPLAY: TechnoToStr := 'Raster Display'; 
          DT_RASPRINTER: TechnoToStr := 'Raster Printer'; 
          DT_RASCAMERA: TechnoToStr  := 'Raster Camera'; 
          DT_CHARSTREAM: TechnoToStr := 'Character Stream'; 
          DT_METAFILE: TechnoToStr   := 'Metafile'; 
          DT_DISPFILE: TechnoToStr   := 'Display file'; 
        end; 
      end; 
     
      //--Main Procedure 
      //---------------------------------------------------------- 
    begin 
      DevCtrl.SetFocus; 
      DevCtrl.Visible := False; 
      if Printer.PrinterIndex < 0 then Exit; 
      // Device Organisation 
      try 
     
        if not (GetMapMode(Printer.Handle) = MM_TEXT) then 
          SetMapMode(Printer.Handle, MM_Text); 
        DevCtrl.Clear; 
     
        Sep := '______________________________________________________________________________________________'; 
        DevCtrl.Lines.Add(sep); 
        DevCtrl.Lines.Add(''); 
        DevCtrl.Lines.Add(' PRINTER : ' + Printer.Printers[Printer.PrinterIndex]); 
        DevCtrl.Lines.Add(sep); 
        DevCtrl.Lines.Add(''); 
     
        DevCtrl.Lines.Add(sep); 
        DevCtrl.Lines.Add(''); 
        DevCtrl.Lines.Add(Format('%36S = %D', ['NUMBER Of COPIES', Printer.Copies])); 
        if Printer.Orientation = poLandscape then 
          DevCtrl.Lines.Add(Format('%36S = LANDSCAPE', ['ORIENTATION'])); 
        if Printer.Orientation = poPortrait then 
          DevCtrl.Lines.Add(Format('%36S = PORTRAIT', ['ORIENTATION'])); 
     
     
        DevCtrl.Lines.Add(sep); 
        DevCtrl.Lines.Add(''); 
        MakeInt('DRIVERVERSION', DRIVERVERSION); 
        DevCtrl.Lines.Add(Format(' %36S = %S', ['TECHNOLOGY', 
          UpperCase(TechnoToStr(GetDeviceCaps(Printer.Handle, Technology)))])); 
        DevCtrl.Lines.Add(sep); 
        DevCtrl.Lines.Add(''); 
        MakeInt('WIDTH [mm]', HORZSIZE); 
        MakeInt('HEIGHT [mm]', VERTSIZE); 
        MakeInt('WIDTH [pix]', HORZRES); 
        MakeInt('HEIGHT [pix]', VERTRES); 
        DevCtrl.Lines.Add(sep); 
        DevCtrl.Lines.Add(''); 
        MakeInt('Physical Width [pix]', PHYSICALWIDTH); 
        MakeInt('Physical Height[pix]', PHYSICALHEIGHT); 
        MakeInt('Physical Offset X [pix]', PHYSICALOFFSETX); 
        MakeInt('Physical Offset Y [pix]', PHYSICALOFFSETY); 
        MakeInt('SCALING FACTOR X', SCALINGFACTORX); 
        MakeInt('SCALING FACTOR Y', SCALINGFACTORY); 
        DevCtrl.Lines.Add(sep); 
        DevCtrl.Lines.Add(''); 
        MakeInt('horizontal [DPI]', LOGPIXELSX); 
        MakeInt('vertial [DPI]', LOGPIXELSY); 
        MakeInt('BITS PER PIXEL', BITSPIXEL); 
        MakeInt('COLOR PLANES', PLANES); 
        DevCtrl.Lines.Add(sep); 
        DevCtrl.Lines.Add(''); 
        MakeInt('NUMBER OF BRUSHES', NUMBRUSHES); 
        MakeInt('NUMBER OF PENS', NUMPENS); 
        MakeInt('NUMBER OF FONTS', NUMFONTS); 
        MakeInt('NUMBER OF COLORS', NUMCOLORS); 
        DevCtrl.Lines.Add(sep); 
        DevCtrl.Lines.Add(''); 
        MakeInt('ASPECT Ratio X [DPI]', ASPECTX); 
        MakeInt('ASPECT Ratio Y [DPI]', ASPECTY); 
        MakeInt('ASPECT Ratio XY [DPI]', ASPECTXY); 
        DevCtrl.Lines.Add(sep); 
        DevCtrl.Lines.Add(''); 
        MakeInt('SIZE OF PALETTE', SIZEPALETTE); 
        MakeInt('RESERVED TO SYSTEM PALETTE **', NUMRESERVED); 
        MakeInt('ACTUAL RASTER RESOLUTION **', COLORRES); 
        DevCtrl.Lines.Add(''); 
        DevCtrl.Lines.Add(' **...only true if KEY RASTERCAPS(RC_PALETTE)= ON'); 
        MakeFlag('... KEY RASTERCAPS (RC_PALETTE)', RasterCaps, RC_PALETTE); 
        DevCtrl.Lines.Add(''); 
     
        MakeHex('Clipping Capablities ', ClipCaps); 
        DevCtrl.Lines.Add(sep); 
        DevCtrl.Lines.Add(''); 
        MakeFlag('No Support ', ClipCaps, CP_NONE); 
        MakeFlag('Support Rectangles', ClipCaps, CP_RECTANGLE); 
        MakeFlag('Support PolyRegion 32 Bit', ClipCaps, CP_REGION); 
     
        MakeHex('Raster Printing Flags ', RasterCaps); 
        DevCtrl.Lines.Add(sep); 
        DevCtrl.Lines.Add(''); 
        MakeFlag('Support Bitmap Transfer', RasterCaps, RC_BITBLT); 
        MakeFlag('Support Banding', RasterCaps, RC_BANDING); 
        MakeFlag('Support Scaling', RasterCaps, RC_SCALING); 
        MakeFlag('Support Bitmaps > 64 kByte', RasterCaps, RC_BITMAP64); 
        MakeFlag('Support features of Win 2.0', RasterCaps, RC_GDI20_OUTPUT); 
        MakeFlag('Support Set~/GetDIBITS()', RasterCaps, RC_DI_BITMAP); 
        MakeFlag('Support Palette Devices', RasterCaps, RC_PALETTE); 
        MakeFlag('Support SetDIBitsToDevice()', RasterCaps, RC_DIBTODEV); 
        MakeFlag('Support Floodfill', RasterCaps, RC_FLOODFILL); 
        MakeFlag('Support StretchBlt()', RasterCaps, RC_STRETCHBLT); 
        MakeFlag('Support StretchBID()', RasterCaps, RC_STRETCHDIB); 
        MakeFlag('Support DIBS', RasterCaps, RC_DEVBITS); 
     
        MakeHex('Curve Printion Flages', CurveCaps); 
        DevCtrl.Lines.Add(sep); 
        DevCtrl.Lines.Add(''); 
        MakeFlag('No Curve support', CurveCaps, CC_NONE); 
        MakeFlag('Support Circles', CurveCaps, CC_Circles); 
        MakeFlag('Support Pie', CurveCaps, CC_PIE); 
        MakeFlag('Support Arces', CurveCaps, CC_CHORD); 
        MakeFlag('Support Ellipses', CurveCaps, CC_ELLIPSEs); 
        MakeFlag('Support WIDE FRAMES', CurveCaps, CC_WIDE); 
        MakeFlag('Support STYLED FRAMES', CurveCaps, CC_STYLED); 
        MakeFlag('Support WIDE&STYLED FRAMES', CurveCaps, CC_WIDESTYLED); 
        MakeFlag('Support INTERIORS', CurveCaps, CC_INTERIORS); 
        MakeFlag('Support ROUNDRECT', CurveCaps, CC_ROUNDRECT); 
     
        MakeHex('Line & Polygon Printing Flags', LineCaps); 
        DevCtrl.Lines.Add(sep); 
        DevCtrl.Lines.Add(''); 
        MakeFlag('No Line Support', LineCaps, LC_NONE); 
        MakeFlag('Support Polylines', LineCaps, LC_PolyLine); 
        MakeFlag('Support Marker', LineCaps, LC_Marker); 
        MakeFlag('Support PolyMarker', LineCaps, LC_PolyMarker); 
        MakeFlag('Support Wide Lines', LineCaps, LC_WIDE); 
        MakeFlag('Support STYLED Lines', LineCaps, LC_STYLED); 
        MakeFlag('Support WIDE&STYLED Lines', LineCaps, LC_WIDESTYLED); 
        MakeFlag('Support Lines Interiors', LineCaps, LC_INTERIORS); 
     
        MakeHex('Polygon (Areal) Printing Flags', POLYGONALCAPS); 
        DevCtrl.Lines.Add(sep); 
        DevCtrl.Lines.Add(''); 
        MakeFlag('No Polygon Support', PolygonalCaps, PC_NONE); 
        MakeFlag('Filling Alternate Polygons', PolygonalCaps, PC_POLYGON); 
        MakeFlag('Drawing Rectangles', PolygonalCaps, PC_RECTANGLE); 
        MakeFlag('Filling Winding Polygons', PolygonalCaps, PC_WINDPOLYGON); 
        MakeFlag('Drawing Trapezoid (??Flag)', PolygonalCaps, PC_Trapezoid); 
        MakeFlag('Drawing a ScanLine', PolygonalCaps, PC_SCANLINE); 
        MakeFlag('Drawing Wide Border', PolygonalCaps, PC_WIDE); 
        MakeFlag('Drawing Styled Border', PolygonalCaps, PC_STYLED); 
        MakeFlag('Drawing WIDE&STYLED Border', PolygonalCaps, PC_WIDESTYLED); 
        MakeFlag('Drawing Interiors', PolygonalCaps, PC_INTERIORS); 
     
        MakeHex('Text Printing Flags', TEXTCAPS); 
        DevCtrl.Lines.Add(sep); 
        DevCtrl.Lines.Add(''); 
        MakeFlag('Support Character Output Precision', TextCaps, TC_OP_CHARACTER); 
        MakeFlag('Support Stroke Output Precision', TextCaps, TC_OP_STROKE); 
        MakeFlag('Support Stroke Clip Precision', TextCaps, TC_CP_STROKE); 
        MakeFlag('Support 90° Character Rotation', TextCaps, TC_CR_90); 
        MakeFlag('Support any Character Rotaion', TextCaps, TC_CR_ANY); 
        MakeFlag('Support Character Scaling in X&Y', TextCaps, TC_SF_X_YINDEP); 
        MakeFlag('Support Character Scaling REAL', TextCaps, TC_SA_DOUBLE); 
        MakeFlag('Support Character Scaling RATIONAL', TextCaps, TC_SA_INTEGER); 
        MakeFlag('Support Character Scaling EXACT', TextCaps, TC_SA_CONTIN); 
        MakeFlag('Support Character Weight REAL', TextCaps, TC_EA_DOUBLE); 
        MakeFlag('Support Character Italic', TextCaps, TC_IA_ABLE); 
        MakeFlag('Support Character Underline', TextCaps, TC_UA_ABLE); 
        MakeFlag('Support Character Strikeout', TextCaps, TC_SO_ABLE); 
        MakeFlag('Support Character as RASTER FONT', TextCaps, TC_RA_ABLE); 
        MakeFlag('Support Character as VECTOR FONT', TextCaps, TC_VA_ABLE); 
        MakeFlag('Reserved Flag ???', TextCaps, TC_Reserved); 
        MakeFlag('DEVICE NOT USE a SCROLLBIT BLOCK ?', TextCaps, TC_SCROLLBLT); 
        DevCtrl.Lines.Insert(0, '..THE RESULTS ARE:'); 
      except 
        // MessageDlg('The Current Printer is not valid ! ', 
        // mtError,[mbok],0); 
        Printer.PrinterIndex := -1; 
        DevCtrl.Lines.Add(' ! The Printer is not valid !'); 
      end; 
      DevCtrl.Visible := True; 
      DevCtrl.SetFocus; 
    end; 

