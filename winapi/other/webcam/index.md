---
Title: Как работать с web-камерой?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как работать с web-камерой?
===========================

First of all, get the SDK at <http://developer.logitech.com>

After installation, open delphi and Import ActiveX Control VPortal2 from
the list. Now, create a new form, and put a VideoPortal from the ActiveX
panel and a button. In the uses, add VideoPortal

On the OnShow add:

    VideoPortal1.PrepareControl('QCSDK',
      'HKEY_LOCAL_MACHINE\Software\JCS Programmation\QCSDK', 0);
    VideoPortal1.EnableUIElements(UIELEMENT_STATUSBAR, 0, 0);
    VideoPortal1.ConnectCamera2;
    VideoPortal1.EnablePreview := 1;

On the ButtonClick add:

    var
      BMP: TBitmap;
      JPG: TJpegImage;
      L: string;
    begin
      F := 'Photos\test.jpg';
      VideoPortal1.StampBackgroundColor := clYellow;
      VideoPortal1.StampTextColor := clBlack;
      VideoPortal1.StampFontName := 'Arial';
      VideoPortal1.StampPointSize := 10;
      VideoPortal1.StampTransparentBackGround := 0;
      L := Format(' %s - %s ', [DateTimeToStr(Now), Num]);
      VideoPortal1.PictureToFile(0, 24, 'Temp.bmp', L);
      BMP := TBitmap.Create;
      JPG := TJpegImage.Create;
      BMP.LoadFromFile('Temp.bmp');
      JPG.CompressionQuality := 85;
      JPG.Assign(BMP);
      JPG.SaveToFile(F);
      BMP.Free;
      JPG.Free;
    end;

It\'s all, run the application, you will see the image from the camera,
click on the button to get a picture.

Here is a copy a VideoPortal.Pas (constants).

    unit VideoPortal;
     
    interface
    // Copyright (c) 1996-2000 Logitech, Inc.  All Rights Reserved
    // User Interface Element, codes used with EnableUIElement method
    const
      UIELEMENT_640x480 = 0;
    const
      UIELEMENT_320x240 = 1;
    const
      UIELEMENT_PCSMART = 2;
    const
      UIELEMENT_STATUSBAR = 3;
    const
      UIELEMENT_UI = 4;
    const
      UIELEMENT_CAMERA = 5;
    const
      UIELEMENT_160x120 = 6;
     
    // Camera status codes, returned by CameraState property
    const
      CAMERA_OK = 0;
    const
      CAMERA_UNPLUGGED = 1;
    const
      CAMERA_INUSE = 2;
    const
      CAMERA_ERROR = 3;
    const
      CAMERA_SUSPENDED = 4;
    const
      CAMERA_DUAL_DETACHED = 5;
    const
      CAMERA_UNKNOWNSTATUS = 10;
     
    // Movie Recording Modes, used with MovieRecordMode property
    const
      SEQUENCECAPTURE_FPS_USERSPECIFIED = 1;
    const
      SEQUENCECAPTURE_FPS_FASTASPOSSIBLE = 2;
    const
      STEPCAPTURE_MANUALTRIGGERED = 3;
     
    // Movie Creation Flags, used with MovieCreateFlags property
    const
      MOVIECREATEFLAGS_CREATENEW = 1;
    const
      MOVIECREATEFLAGS_APPEND = 2;
     
    // Notification Codes
    const
      NOTIFICATIONMSG_MOTION = 1;
    const
      NOTIFICATIONMSG_MOVIERECORDERROR = 2;
    const
      NOTIFICATIONMSG_CAMERADETACHED = 3;
    const
      NOTIFICATIONMSG_CAMERAREATTACHED = 4;
    const
      NOTIFICATIONMSG_IMAGESIZECHANGE = 5;
    const
      NOTIFICATIONMSG_CAMERAPRECHANGE = 6;
    const
      NOTIFICATIONMSG_CAMERACHANGEFAILED = 7;
    const
      NOTIFICATIONMSG_POSTCAMERACHANGED = 8;
    const
      NOTIFICATIONMSG_CAMERBUTTONCLICKED = 9;
    const
      NOTIFICATIONMSG_VIDEOHOOK = 10;
    const
      NOTIFICATIONMSG_SETTINGDLGCLOSED = 11;
    const
      NOTIFICATIONMSG_QUERYPRECAMERAMODIFICATION = 12;
    const
      NOTIFICATIONMSG_MOVIESIZE = 13;
     
    // Error codes used by NOTIFICATIONMSG_MOVIERECORDERROR notification:
    const
      WRITEFAILURE_RECORDINGSTOPPED = 0;
    const
      WRITEFAILURE_RECORDINGSTOPPED_FILECORRUPTANDDELETED = 1;
    const
      WRITEFAILURE_CAMERA_UNPLUGGED = 2;
    const
      WRITEFAILURE_CAMERA_SUSPENDED = 3;
     
    // Camera type codes, returned by GetCameraType method
    const
      CAMERA_UNKNOWN = 0;
    const
      CAMERA_QUICKCAM_VC = 1;
    const
      CAMERA_QUICKCAM_QUICKCLIP = 2;
    const
      CAMERA_QUICKCAM_PRO = 3;
    const
      CAMERA_QUICKCAM_HOME = 4;
    const
      CAMERA_QUICKCAM_PRO_B = 5;
    const
      CAMERA_QUICKCAM_TEKCOM = 6;
    const
      CAMERA_QUICKCAM_EXPRESS = 7;
    const
      CAMERA_QUICKCAM_FROG = 8; // MIGHT CHANGE NAME BUT ENUM STAYS THE SAME
    const
      CAMERA_QUICKCAM_EMERALD = 9; // MIGHT CHANGE NAME BUT ENUM STAYS THE SAME
     
    // Camera-specific property codes used by Set/GetCameraPropertyLong
    const
      PROPERTY_ORIENTATION = 0;
    const
      PROPERTY_BRIGHTNESSMODE = 1;
    const
      PROPERTY_BRIGHTNESS = 2;
    const
      PROPERTY_CONTRAST = 3;
    const
      PROPERTY_COLORMODE = 4;
    const
      PROPERTY_REDGAIN = 5;
    const
      PROPERTY_BLUEGAIN = 6;
    const
      PROPERTY_SATURATION = 7;
    const
      PROPERTY_EXPOSURE = 8;
    const
      PROPERTY_RESET = 9;
    const
      PROPERTY_COMPRESSION = 10;
    const
      PROPERTY_ANTIBLOOM = 11;
    const
      PROPERTY_LOWLIGHTFILTER = 12;
    const
      PROPERTY_IMAGEFIELD = 13;
    const
      PROPERTY_HUE = 14;
    const
      PROPERTY_PORT_TYPE = 15;
    const
      PROPERTY_PICTSMART_MODE = 16;
    const
      PROPERTY_PICTSMART_LIGHT = 17;
    const
      PROPERTY_PICTSMART_LENS = 18;
    const
      PROPERTY_MOTION_DETECTION_MODE = 19;
    const
      PROPERTY_MOTION_SENSITIVITY = 20;
    const
      PROPERTY_WHITELEVEL = 21;
    const
      PROPERTY_AUTO_WHITELEVEL = 22;
    const
      PROPERTY_ANALOGGAIN = 23;
    const
      PROPERTY_AUTO_ANALOGGAIN = 24;
    const
      PROPERTY_LOWLIGHTBOOST = 25;
    const
      PROPERTY_COLORBOOST = 26;
    const
      PROPERTY_ANTIFLICKER = 27;
    const
      PROPERTY_OPTIMIZATION_SPEED_QUALITY = 28;
    const
      PROPERTY_STREAM_HOOK = 29;
    const
      PROPERTY_LED = 30;
     
    const
      ADJUSTMENT_MANUAL = 0;
    const
      ADJUSTMENT_AUTOMATIC = 1;
     
    const
      ORIENTATIONMODE_NORMAL = 0;
    const
      ORIENTATIONMODE_MIRRORED = 1;
    const
      ORIENTATIONMODE_FLIPPED = 2;
    const
      ORIENTATIONMODE_FLIPPED_AND_MIRRORED = 3;
     
    const
      COMPRESSION_Q0 = 0;
    const
      COMPRESSION_Q1 = 1;
    const
      COMPRESSION_Q2 = 2;
     
    const
      ANTIFLICKER_OFF = 0;
    const
      ANTIFLICKER_50Hz = 1;
    const
      ANTIFLICKER_60Hz = 2;
     
    const
      OPTIMIZE_QUALITY = 0;
    const
      OPTIMIZE_SPEED = 1;
     
    const
      LED_OFF = 0;
    const
      LED_ON = 1;
    const
      LED_AUTO = 2;
    const
      LED_MAX = 3;
     
    const
      PICTSMART_LIGHTCORRECTION_NONE = 0;
    const
      PICTSMART_LIGHTCORRECTION_COOLFLORESCENT = 1;
    const
      PICTSMART_LIGHTCORRECTION_WARMFLORESCENT = 2;
    const
      PICTSMART_LIGHTCORRECTION_OUTSIDE = 3;
    const
      PICTSMART_LIGHTCORRECTION_TUNGSTEN = 4;
     
    const
      PICTSMART_LENSCORRECTION_NORMAL = 0;
    const
      PICTSMART_LENSCORRECTION_WIDEANGLE = 1;
    const
      PICTSMART_LENSCORRECTION_TELEPHOTO = 2;
     
    const
      CAMERADLG_GENERAL = 0;
    const
      CAMERADLG_ADVANCED = 1;
     
    implementation
    end.
     
Example shows how to use the PictureToMemory method in the QuickCam SDK. 
     
    type
      TMemoryStream = class(Classes.TMemoryStream);
     
    var
      MS: TMemoryStream;
      lSize: LongInt;
      pBuffer: ^Byte;
     
    begin
     
      MS := TMemoryStream.Create;
      bitmap1 := TBitmap.Create;
     
      try
        if VideoPortal1.PictureToMemory(0, 24, 0, lSize, '') = 1 then
        begin
          pBuffer := AllocMem(lSize);
          if VideoPortal1.PictureToMemory(0, 24, integer(pBuffer), lSize, '') = 1 then
          begin
            MS.SetPointer(pBuffer, lSize);
            bitmap1.loadfromstream(MS);
          end;
        end;
      finally
        MS.Free;
        FreeMem(pBuffer);
      end;
    end;

