import React from 'react';
import { FlatList, TouchableOpacity, Text } from 'react-native';

const CategoryList = ({ categories, onEnter }) => {
  return (
    <FlatList
      data={categories}
      renderItem={({ item }) => (
        <TouchableOpacity
          style={{
            flex: 1,
            marginRight: 6,
            flexDirection: 'column',
            alignItems: 'center',
            justifyContent: 'center',
            borderWidth: 1,
            backgroundColor: '#34C759',
            borderColor: '#0569FF',
            borderRadius: 8,
            marginBottom: 8,
            height: 40,
          }}
          onPress={() => onEnter(item.url)}
        >
          <Text style={{ fontSize: 14, color: 'black' }}>{item.name}</Text>
        </TouchableOpacity>
      )}
      keyExtractor={(item, index) => index.toString()}
    />
  );
};

export default CategoryList;