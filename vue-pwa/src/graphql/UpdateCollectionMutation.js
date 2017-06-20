import gql from 'graphql-tag'

export default gql`
  mutation($id: Int!, $title: String!) {
    updateCollection(id: $id, title: $title) {
      id
      title
      bookmarks {
        total
      }
    }
  }
`
