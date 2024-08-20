import React from 'react';
import { Text } from 'react-native';

const MessageText = ({ text }) => {
  return <Text style={{ fontSize: 14, width: '100%', flex: 1, paddingLeft: 0 }}>{text}</Text>;
};

export default MessageText;