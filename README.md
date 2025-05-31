# Web Configurator

A modern, interactive product configurator built with Vue.js that allows users to customize products with real-time visualization and request quotes.

![Web Configurator Screenshot](https://images.pexels.com/photos/1957478/pexels-photo-1957478.jpeg?auto=compress&cs=tinysrgb&w=600)

## Features

- **Interactive Product Configuration**: Customize products with various options and see changes in real-time
- **Multi-view Support**: View products from different angles
- **Dynamic Pricing**: Automatically calculate total price based on selected options
- **Quote Request System**: Submit customized product configurations for quotes
- **Admin Panel**: Manage products, configurations, and quote requests
- **Responsive Design**: Works on desktop, tablet, and mobile devices
- **Share Configurations**: Generate shareable links for specific configurations
- **Export Configurations**: Save or download your custom configuration as an image

## Getting Started

### Prerequisites

- Node.js 14.x or higher
- npm 6.x or higher

### Installation

1. Clone the repository:
```bash
git clone https://github.com/yourusername/web-configurator.git
cd web-configurator
```

2. Install dependencies:
```bash
npm install
```

3. Start the development server:
```bash
npm run dev
```

4. Open your browser and navigate to `http://localhost:5173`

### Building for Production

```bash
npm run build
```

The built files will be in the `dist` directory.

## Project Structure

```
web-configurator/
├── public/              # Static assets
├── src/
│   ├── assets/          # Images, fonts, and CSS
│   ├── backend/         # Backend API simulation
│   ├── components/      # Vue components
│   │   ├── admin/       # Admin panel components
│   │   └── ...          # Other components
│   ├── router/          # Vue Router configuration
│   ├── views/           # Page components
│   ├── App.vue          # Main application component
│   └── main.js          # Application entry point
├── index.html           # HTML template
├── package.json         # Project dependencies
└── vite.config.js       # Vite configuration
```

## Core Components

### ProductPreview.vue

Displays the product with all selected options. Supports multiple views and interactive controls.

```javascript
<ProductPreview 
  :product="activeProduct" 
  :active-view="activeView"
  :active-layers="activeLayers" 
  @change-view="changeView"
/>
```

### ControlsAccordion.vue

Provides an accordion interface for selecting product options by category.

```javascript
<ControlsAccordion 
  :product="activeProduct" 
  :active-layers="activeLayers"
  @toggle-layer="toggleLayer" 
/>
```

### Summary.vue

Displays a summary of the selected options and total price.

```javascript
<Summary 
  :summary-data="summaryData" 
  :base-price="basePrice"
  :total-price="totalPrice" 
/>
```

### QuoteForm.vue

Form for submitting quote requests.

```javascript
<QuoteForm 
  :user-info="userInfo" 
  @update-field="updateField"
  @submit="submitQuote" 
/>
```

## State Management

The application uses Vuex for state management. The main store includes:

- **activeProduct**: Currently selected product
- **activeView**: Current view (e.g., "front", "side")
- **activeLayers**: Array of selected option IDs
- **basePrice**: Base price of the product
- **totalPrice**: Calculated total price including all options
- **summaryData**: Structured summary of selected options
- **userInfo**: User information for quote requests
- **currentStep**: Current step in the configuration process

## Extending the Configurator

### Adding New Products

To add a new product, create a new product object in the `backend/index.js` file:

```javascript
{
  id: 'product-id',
  name: 'Product Name',
  thumbnail: 'path/to/thumbnail.jpg',
  shortDescription: 'Short product description',
  description: 'Full product description',
  basePrice: 999,
  isNew: true,
  views: [
    {
      id: 'front',
      name: 'Front',
      baseImage: 'path/to/front-view.jpg',
      thumbnail: 'path/to/front-thumbnail.jpg'
    },
    // Add more views as needed
  ],
  categories: [
    { id: 'category-id', name: 'Category Name' },
    // Add more categories as needed
  ],
  layers: [
    {
      id: 'layer-id',
      name: 'Layer Name',
      categoryId: 'category-id',
      price: 100,
      views: {
        front: 'path/to/layer-front-view.jpg',
        // Add images for other views
      }
    },
    // Add more layers as needed
  ]
}
```

### Creating Custom Layer Types

The configurator supports different types of layers, including:

- **Standard layers**: Basic product options with images
- **Color layers**: Color options (set `type: 'color'` and provide a `color` value)

To add a new layer type:

1. Extend the layer object with your custom properties
2. Update the `ControlsAccordion.vue` component to handle the new layer type
3. Update the `ProductPreview.vue` component to render the new layer type

### Customizing the Admin Panel

The admin panel (`src/components/admin/AdminPanel.vue`) can be extended to add more features:

- Add new tabs for additional management sections
- Extend the product form to support more properties
- Add user management functionality
- Implement more advanced quote management features

## API Integration

The project includes a simulated backend API in the `src/backend` directory. In a real-world scenario, you would replace these functions with actual API calls.

To integrate with a real backend:

1. Update the API functions in `src/backend/api.js` to make actual HTTP requests
2. Implement proper error handling and loading states
3. Add authentication for the admin panel

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Acknowledgments

- [Vue.js](https://vuejs.org/)
- [Vuex](https://vuex.vuejs.org/)
- [Vite](https://vitejs.dev/)
- [html2canvas](https://html2canvas.hertzen.com/)