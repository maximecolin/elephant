import gql from 'graphql-tag'

export default gql`
  mutation($title: String!) {
    collection(title: $title) {
      id
      title
    }
  }
`
