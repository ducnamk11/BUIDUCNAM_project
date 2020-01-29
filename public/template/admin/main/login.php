<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <?php echo $this->_metaHTTP;?>
  <?php echo $this->_metaName;?>
  <?php echo $this->_title;?>
  <?php echo $this->_cssFiles;?>
  <script type="text/javascript" src="/mvc/XayDungUngDung/bookstore/public/template/default/main/js/jquery.js"></script>
  <script type="text/javascript" src="/mvc/XayDungUngDung/bookstore/public/template/default/main/js/custom.js"></script>
  <?php echo $this->_jsFiles;?>
  
</head>
<body>
          <?php require_once MODULE_PATH. $this->_moduleName . DS . 'views' . DS . $this->_fileView . '.php'; ?>

</body>
</html>
