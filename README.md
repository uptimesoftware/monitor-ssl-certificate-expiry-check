# SSL Certificate Expiry Check
## Tags : plugin   ssl   certificate  

## Category: plugin

##Version Compatibility<br/>Module Name</th><th>up.time Monitoring Station Version</th>


  
    * SSL Certificate Expiry Check - 7.1, 7.0, 6.0, 5.5, 5.4, 5.3, 5.2
  


### Description: Checks whether an SSL certificate is going to expire (checks the number of days remaining and lets you set an alert threshold).

### Supported Monitoring Stations: 7.1, 7.0, 6.0, 5.5, 5.4, 5.3, 5.2
### Supported Agents: None; no agent required
### Installation Notes: <p><a href="https://github.com/uptimesoftware/uptime-plugin-manager">Install using the up.time Plugin Manager</a>
2. To enable the monitor, edit your php.ini (in (uptime_dir)/apache/php/) and uncomment the following line by removing the semicolon from the
front:
;extension=php_curl.dll
It should now read:
extension=php_curl.dll</p>

### Dependencies: <p>Read README output when installing with the up.time Plugin Manager; a small change needs to be made to php.ini to enable lib CURL.</p>

### Input Variables: 
### Output Variables: * days remaining to expiry
### Languages Used: * PHP

