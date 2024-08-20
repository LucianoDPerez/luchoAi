import React from 'react';
import { View, Image, Text } from 'react-native';

const MessageHeader = ({ authorName, iconSource, timestamp }) => {
  return (
    <View style={{ flexDirection: 'row', alignItems: 'center', justifyContent: 'space-between' }}>
      <View style={{ flexDirection: 'row', alignItems: 'center', gap: 8 }}>
        <Image source={iconSource} style={{ width: 28, height: 28 }} />
        <Text style={{ fontWeight: 500, color: 'black' }}>{authorName}</Text>
      </View>
      <Text style={{ fontSize: 10, fontWeight: 600 }}>{timestamp}</Text>
    </View>
  );
};

export default MessageHeader;