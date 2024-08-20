import { StyleSheet } from 'react-native';

const styles = StyleSheet.create({
  container: {
    flex: 1,
    paddingTop: 10,
    backgroundColor: '#4A90E2', // Corrigido el error tipográfico
  },
  header: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'flex-start',
    paddingVertical: 16,
    paddingHorizontal: 20,
    backgroundColor: '#4A90E2', // Un azul vibrante
    shadowColor: "#000",
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.25,
    shadowRadius: 3.84,
    elevation: 5,
  },
  icon: {
    width: 30,
    height: 30,
    marginRight: 12,
  },
  headerText: {
    fontSize: 28,
    fontFamily: 'Poppins_700Bold',
    color: '#FFFFFF', // Texto blanco para contrastar con el fondo azul
    textShadowColor: 'rgba(0, 0, 0, 0.1)',
    textShadowOffset: { width: 1, height: 1 },
    textShadowRadius: 3,
  },
  searchBar: {
    backgroundColor: '#ffffff',
    width: '100%',
    position: 'absolute',
    bottom: 0,
    flexDirection: 'row',
    justifyContent: 'center',
    alignItems: 'center',
    paddingHorizontal: 32,
    paddingVertical: 16,
    // Removido gap y gestionado con padding
  },
  input: {
    backgroundColor: '#fff',
    width: '90%',
    fontSize: 16,
    paddingVertical: 16,
    paddingHorizontal: 16,
    borderRadius: 32,
    borderWidth: 0.1,
    alignSelf: 'center',
  },
  // Añadir márgenes a los mensajes en el FlatList
  message: {
    marginVertical: 8,
    padding: 12,
    backgroundColor: '#fff',
    borderRadius: 8,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.2,
    shadowRadius: 4,
    elevation: 2,
  },
});

export default styles;
