DELETE FROM smartphone;

ALTER TABLE smartphone AUTO_INCREMENT = 1;

INSERT INTO smartphone (brand,model,osName,osVersion) VALUES
  ("Samsung","SM-G930F","Android","7.0"),
  ("Nexus","EX-9","Android","5.5"),
  ("Apple","6","iOS","10.0"),
  ("Apple","X","iOS","11.1");

INSERT INTO Android (fkPhone, sd) VALUES
  (1,4),
  (2,16);

INSERT INTO iPhone (fkPhone, threeDT) VALUES
  (3,0),
  (4,1);

