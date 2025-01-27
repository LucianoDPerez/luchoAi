import React, { useState } from 'react';
import { View, Text, Image, TouchableOpacity } from 'react-native';

import actionScreenStyles from '../styles/components/actionScreenStyles';

const ActionsScreen = ({ onEnter }) => {     
  return (
    <View style={actionScreenStyles.welcomeContainer}>
      <View  >
        <Text style={actionScreenStyles.welcomeText}>
          Bienvenido! Puedes hacer lo siguiente:
        </Text>
      </View>
    
      <View style={{ flexDirection: 'row', justifyContent: 'space-between', marginRight: 8 }}>            
                <TouchableOpacity 
                    onPress={() => {         
                      const action = 'pronostico';            
                      onEnter(action); 
                    }}
                    style={{ flex: 1, marginRight: 6, flexDirection: 'column', alignItems: 'center', justifyContent: 'center', 
                                    borderWidth: 1, backgroundColor: '#0569FF',
                                    borderColor: '#0569FF', borderRadius: 8, marginBottom: 4  }}>
                    <Image source={require('../assets/icons/weather.png')} style={{ width: 24, height: 24, marginBottom: 4 }} />
                    <Text style={{ color: 'white', fontSize: 12 }}>Pronostico</Text>
                </TouchableOpacity>
                <TouchableOpacity 
                    onPress={() => {         
                      const action = 'dolar';            
                      onEnter(action); 
                    }}
                    style={{ flex: 1, marginRight: 6, flexDirection: 'column', alignItems: 'center', justifyContent: 'center', 
                                    borderWidth: 1, backgroundColor: '#0569FF',
                                    borderColor: '#0569FF', borderRadius: 8, marginBottom: 4  }}>
                    <Image source={require('../assets/icons/dollar.png')} style={{ width: 24, height: 24, marginBottom: 4 }} />
                    <Text style={{ color: 'white', fontSize: 12 }}>Precio Dolar</Text>
                </TouchableOpacity>            
        </View>

        <View style={{ flexDirection: 'row', justifyContent: 'space-between', marginRight: 8 }}>
            <TouchableOpacity 
                onPress={() => {         
                  const action = 'Farmacias en mi localidad actual';            
                  onEnter(action); 
                }}
                style={{ flex: 1, marginRight: 6, flexDirection: 'column', alignItems: 'center', justifyContent: 'center', 
                                    borderWidth: 1, backgroundColor: '#0569FF',
                                    borderColor: '#0569FF', borderRadius: 8  }}>
                <Image source={require('../assets/icons/farmacy.png')} style={{ width: 24, height: 24, marginBottom: 4 }} />
                <Text style={{ color: 'white', fontSize: 12, textAlign: 'center' }}>Farmacias</Text>
            </TouchableOpacity>

            <TouchableOpacity 
                onPress={() => {         
                  const action = 'compras';            
                  onEnter(action); 
                }}
                style={{ flex: 1, marginRight: 6, flexDirection: 'column', alignItems: 'center', justifyContent: 'center', 
                                    borderWidth: 1, backgroundColor: '#0569FF',
                                    borderColor: '#0569FF', borderRadius: 8  }}>
                <Image source={require('../assets/icons/shop.png')} style={{ width: 24, height: 24, marginBottom: 4 }} />
                <Text style={{ color: 'white', fontSize: 12, textAlign: 'center' }}>Donde comprar?</Text>
            </TouchableOpacity>
        </View>
    </View>
  );
};

export default ActionsScreen;