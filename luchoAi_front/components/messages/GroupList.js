import React from 'react';
import { FlatList, View, Text } from 'react-native';

const GroupedList = ({ values }) => {
  return (
    <FlatList
      data={values}
      renderItem={({ item }) => (
        <View style={{ marginBottom: 10 }}>
          <FlatList
            data={Object.entries(item)}
            renderItem={({ item: [key, value], index }) => (
              <View>
                <Text style={index === 0 ? { fontWeight: 'bold' } : {}}>
                  {key} {value}
                </Text>
              </View>
            )}
            keyExtractor={(item, index) => index.toString()}
          />
        </View>
      )}
      keyExtractor={(item, index) => index.toString()}
    />
  );
};

export default GroupedList;